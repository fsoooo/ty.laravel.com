<?php

namespace App\Http\Controllers\BackendControllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Agent;
use App\Models\Ditch;
use App\Helper\LogHelper;
use App\Models\TaskDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;

/**
 * 任务控制器
 *
 * @package App\Http\Controllers\BackendControllers
 */
class TaskController extends Controller
{
    /**
     * 任务列表
     *
     * @param Request $request
     * @param TaskRepository $taskRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, TaskRepository $taskRepository, Task $task)
    {
        list($ditch_id, $agent_id, $year) = $this->getSearchParameters($request);

        if ($ditch_id < 0) {
            return redirect()->route('backend.task.index');
        }
        // 任务年份
        $years = $this->getYears($task);

        // 全部渠道
        $ditches = Ditch::with(['agents'=>function($query){
            $query->with('user')->where('work_status',1);
        }])->get();
        if (!empty($ditches)) {
            $ditches = $ditches->toArray();
        }
        // 代理人
        $agents = [];
        foreach ($ditches as $ditch) {
            foreach ($ditch['agents'] as $key => $agent) {
                $agents[$ditch['id']][$key]['id'] = $agent['id'];
                $agents[$ditch['id']][$key]['name'] = $agent['user']['name'];
            }
        }
        $agents = json_encode($agents, JSON_UNESCAPED_UNICODE);

        // 若选择了某个渠道，则加入渠道查询
        $selected_ditch = $this->getSelectedDitch($ditch_id);

        // 若选择了某个代理人，则加入代理人查询
        $selected_agent = $this->getSelectedAgent($agent_id);

        // 每月应完成的额度
        $shouldDoneData = $taskRepository->getShouldDoneData($year, $ditch_id, $agent_id);
        // 实际完成的额度
        $haveDoneData = $taskRepository->getHaveDoneData($year, $ditch_id, $agent_id);
        // 查询追加记录
        $taskRecords = $taskRepository->getRecordsPaginate($year, $ditch_id, $agent_id);

        // 总任务额度
        $currentTaskTotalMoney = 0;
        foreach ($taskRecords as $item) {
            $currentTaskTotalMoney += $item['money'];
        }
        $taskTotalMoney = Task::where(DB::raw('DATE_FORMAT(created_at,"%Y")'), $year)->sum('money') / 100;

        $haveDoneSumData = $taskRepository->getHaveDoneSumData($haveDoneData);

        $data = compact(
            'shouldDoneData', 'haveDoneData', 'haveDoneSumData', 'currentTaskTotalMoney', 'taskTotalMoney', 'taskRecords',
            'ditches', 'agents', 'selected_ditch', 'selected_agent', 'years', 'year','ditch_id','agent_id'
        );
        return view('backend_v2.task.index', $data);
    }

    /**
     * 数据处理入库
     *
     * @param Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $money = $request->input('money');
        if (empty($money) || $money < 0) {
            return back()->withErrors('请输入额度');
        }
        $type = $request->input('type');
        if ((int)$type < 0) {
            return back()->withErrors('请选择任务类型');
        }

        $months = [];
        if ($type == 'year') { // 年任务 / 12
            $months = range(1, 12);
            $desc = '添加年任务';
        } elseif ($type == 'season') { // 季任务
            $season = $request->input('season');
            if (empty($season)) {
                return back()->withErrors('请选择季度');
            }
            foreach ($season as $item) {
                if ($item == 1) {
                    $months = array_merge($months, [1, 2, 3]);
                    $desc = '添加第一季度任务';
                } elseif ($item == 2) {
                    $months = array_merge($months, [4, 5, 6]);
                    $desc = '添加第二季度任务';
                }  elseif ($item == 3) {
                    $months = array_merge($months, [7, 8, 9]);
                    $desc = '添加第三季度任务';
                }  elseif ($item == 4) {
                    $months = array_merge($months, [10, 11, 12]);
                    $desc = '添加第四季度任务';
                }
            }
        } elseif ($type == 'month') { // 月任务
            $months = $request->input('months');
            $desc = '添加第' . trim(implode('、', $months), ',') . '月份任务';
            if (empty($months)) {
                return back()->withErrors('请选择月份');
            }
        }
        if ($ditch_id = $request->input('ditches')) {
            $ditch = Ditch::where('id', $ditch_id)->first();
            if ($agent_id = $request->input('agents')) {
                $agents = Agent::with(['ditches', 'user'])->where('id', $agent_id)->get();
                $desc = '向 ' . $ditch->name . ' 渠道下的 ' . $agents[0]->user->name . ' 代理人，' .  $desc;
            } else {
                $agents = Agent::whereHas('ditches', function ($q) use ($ditch_id, $desc) {
                    $q->where('id', $ditch_id);
                })->with('user')->get();
                $desc = '向 ' . $ditch->name . ' 渠道下的所有代理人， ' . $desc;
            }
        } else {
            $desc = '向所有代理人，' . $desc;
            $agents = Agent::with('ditches')->get();
        }

        if ($agents->count() <= 0) {
            return back()->with('status', '选择的渠道下，无代理人');
        }

        DB::beginTransaction();

        try {
            $task = Task::create([
                'type' => $type,
                'money' => $money * 100,
                'desc' => $desc,
                'created_at' => Carbon::now()
            ]);
            $data = [];
            $average_month_money = $money * 100 / count($months); // 额度 / 月的数量 = 每个月应完成的额度
            foreach ($months as $month) {
                $average_agent_money = round($average_month_money / $agents->count());
                foreach ($agents as $agent) {
                    $data[] = [
                        'ditch_id' => $agent->ditches()->first()->id,
                        'agent_id' => $agent->id,
                        'money' => $average_agent_money,
                        'year' => date('Y'),
                        'month' => $month
                    ];
                    $data2[] = [
                        'ditch_id' => $agent->ditches()->first()->id,
                        'agent_id' => $agent->id,
                        'task_id' => $task->id
                    ];
                }
            }
            TaskDetail::insert($data);
            DB::table('task_ditch_agent')->insert($data2);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            LogHelper::logError($request->input(), $e->getMessage());
            return back()->withErrors('追加任务失败');
        }

        return redirect()->route('backend.task.index')->with('status', '添加成功');
    }

    /*
     * 更新月任务
     */
    public function storeMonth(Request $request)
    {
        $month = $request->input('month');
        $money = $request->input('money');
        $ditch_id = $request->input('ditch');
        $agent_id = $request->input('agent');
        $type = 'month';
        $agents = Agent::with(['ditches', 'user'])->get();

        $taskDetail = new TaskDetail();
        $taskDetail = $taskDetail
            ->where('year', date('Y'))
            ->where('month', $month);
        if ($ditch_id) {
            $ditch = Ditch::where('id', $ditch_id)->first();
            $desc = "更新渠道 " . $ditch->name . "，第{$month}月份的任务额度";
            $taskDetail = $taskDetail->where('ditch_id', $ditch_id);
            $agents = Agent::with(['ditches' => function ($q) use ($ditch_id) {
                $q->where('id', $ditch_id);
            }, 'user'])->get();
            if ($agent_id) {
                $agent = Agent::with('user')->where('id', $agent_id)->first();
                $desc = "更新渠道 " . $ditch->name . " 下的 " . $agent->user->name . " 代理人，第{$month}月份的任务额度";
                $taskDetail = $taskDetail->where('agent_id', $agent_id);
                $agents = Agent::with(['ditches', 'user'])->where('id', $agent_id)->get();
            }
        } else {
            $desc = "更新所有代理人，第{$month}月份的任务额度";
        }

        DB::beginTransaction();

        try {
            $task = Task::create([
                'type' => $type,
                'money' => $money * 100,
                'desc' => $desc,
                'created_at' => Carbon::now()
            ]);
            $data = [];
            $taskDetail->delete();
            $data = [];
            $average_agent_money = round($money * 100 / $agents->count());
            foreach ($agents as $agent) {
                $data[] = [
                    'ditch_id' => $agent->ditches()->first()->id,
                    'agent_id' => $agent->id,
                    'money' => $average_agent_money,
                    'year' => date('Y'),
                    'month' => $month
                ];
                $data2[] = [
                    'ditch_id' => $agent->ditches()->first()->id,
                    'agent_id' => $agent->id,
                    'task_id' => $task->id
                ];
            }
            TaskDetail::insert($data);
            DB::table('task_ditch_agent')->insert($data2);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            LogHelper::logError($request->input(), $e->getMessage());
            return back()->withErrors('追加任务失败');
        }

        return back()->with('status', '添加成功');
    }

    /**
     * 获取查询的参数
     *
     * @param Request $request
     *
     * @return array [渠道ID， 代理人ID， 年份]
     */
    protected function getSearchParameters(Request $request)
    {
        return [
            (int)$request->get('ditch'),
            (int)$request->get('agent'),
            (int)$request->get('year') ? (int)$request->get('year') : date('Y')
        ];
    }

    /**
     * 获取任务的所有年份，用于前台筛选年份， 降序排序
     *
     * @param Task $task
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getYears(Task $task)
    {
        return $task->groupBy(DB::raw('DATE_FORMAT(created_at,"%Y")'))
            ->select(DB::raw('DATE_FORMAT(created_at,"%Y") as year'))
            ->orderBy('year','desc')
            ->pluck('year');
    }

    /**
     * 查询选中的渠道
     *
     * @param int $ditch_id
     *
     * @return array
     */
    protected function getSelectedDitch($ditch_id)
    {
        $selected_ditch = [];
        if ($ditch_id) {
            $selected_ditch = Ditch::with(['agents.user'])->where('id', $ditch_id)->first();
            if (empty($selected_ditch)) {
                return back()->withErrors('没有选中的渠道信息');
            }
            $selected_ditch = $selected_ditch->toArray();
        }
        return $selected_ditch;
    }

    /**
     * 查询选中的代理人
     *
     * @param int$agent_id
     *
     * @return array
     */
    protected function getSelectedAgent($agent_id)
    {
        $selected_agent = [];
        if ($agent_id) {
            $selected_agent = Agent::with('user')->where('id', $agent_id)->first();
            if (empty($selected_agent)) {
                return back()->withErrors('没有选中的代理人信息');
            }
            $selected_agent = $selected_agent->toArray();
        }
        return $selected_agent;
    }
}

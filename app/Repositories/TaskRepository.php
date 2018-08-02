<?php
namespace App\Repositories;

use App\Models\Order;
use App\Models\Task;
use App\Models\TaskDetail;
use App\Models\WarrantyRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @package App\Repositories
 */
class TaskRepository
{
    protected $types = [
        'year' => '年任务',
        'season' => '季任务',
        'month' => '月任务'
    ];

    /**
     * @var Task $taskModel
     */
    protected $taskModel;

    /** @var TaskDetail $taskDetailModel */
    protected $taskDetailModel;

    /**
     * @param Task $taskModel
     * @param TaskDetail $taskDetailModel
     */
    public function __construct(Task $taskModel, TaskDetail $taskDetailModel)
    {
        $this->taskModel = $taskModel;
        $this->taskDetailModel = $taskDetailModel;
    }

    /**
     * 查询任务记录
     *
     * @param string $year 年份 例如2017
     * @param null|int $ditch_id 渠道ID
     * @param null|int $agent_id 代理人ID
     *
     * @return array
     */
    public function getRecords($year, $ditch_id = null, $agent_id = null)
    {
        $taskModel = $this->taskModel;
        $taskModel = $taskModel
            ->from('task as a')
            ->leftJoin('task_ditch_agent as b', 'a.id', '=', 'b.task_id');
        if ($ditch_id) {
            $taskModel = $taskModel->where('b.ditch_id', $ditch_id);
        }
        if ($agent_id) {
            $taskModel = $taskModel->where('b.agent_id', $agent_id);
        }
        $tasks = $taskModel
            ->where(DB::raw('DATE_FORMAT(created_at,"%Y")'), $year)
            ->select('a.*')
            ->distinct('a.id')->get();

        foreach ($tasks as $task) {
            $task->type = $this->types[$task->type];
            $task->money = $task->money / 100;
            $task->created_at = Carbon::createFromTimestamp(strtotime($task->created_at));
        }

        return $tasks->toArray();
    }

    /**
     * 查询任务记录 - 分页
     *
     * @param string $year 年份 例如2017
     * @param null|int $ditch_id 渠道ID
     * @param null|int $agent_id 代理人ID
     *
     * @return array
     */
    public function getRecordsPaginate($year, $ditch_id = null, $agent_id = null)
    {
        $taskModel = $this->taskModel;
        $taskModel = $taskModel->from('task as a');
        if ($ditch_id) {
            $taskModel = $taskModel->where('b.ditch_id', $ditch_id)
                ->leftJoin('task_ditch_agent as b', 'a.id', '=', 'b.task_id');
        }
        if ($agent_id) {
            if (!$ditch_id) {
                $taskModel = $taskModel->leftJoin('task_ditch_agent as b', 'a.id', '=', 'b.task_id');
            } else {
                $taskModel = $taskModel->where('b.agent_id', $agent_id);
            }
        }
        $tasks = $taskModel
            ->where(DB::raw('DATE_FORMAT(created_at,"%Y")'), $year)
            ->select('a.*')
            ->distinct('a.id')->paginate(20);

        foreach ($tasks as $task) {
            $task->type = $this->types[$task->type];
            $task->money = $task->money / 100;
            $task->created_at = Carbon::createFromTimestamp(strtotime($task->created_at));
        }

        return $tasks;
    }

    /**
     * 应该完成的额度
     *
     * 返回格式为一维数组:
     * [
     *      0 => 100
     *      1 => 200
     *      ...
     * ]
     * 12个值，是按照月份排序好的
     *
     * @param string $year 年份 例如2017
     * @param null|int $ditch_id 渠道ID
     * @param null|int $agent_id 代理人ID
     *
     * @return array
     */
    public function getShouldDoneData($year, $ditch_id = null, $agent_id = null)
    {
        $taskDetailModel = $this->taskDetailModel;
        if ($ditch_id) {
            $taskDetailModel = $taskDetailModel->where('ditch_id', $ditch_id);
        }
        if ($agent_id) {
            $taskDetailModel = $taskDetailModel->where('agent_id', $agent_id);
        }

        $result = $taskDetailModel
            ->where('year', $year)
            ->groupBy('month')
            ->select(DB::raw('sum(money) as money'), 'month')
            ->get()
            ->toArray();

        $result = $this->format($result);

        return $result;
    }

    /**
     * 查询实际完成的额度
     *
     * 返回格式为一维数组:
     * [
     *      0 => 100
     *      1 => 200
     *      ...
     * ]
     * 12个值，是按照月份排序好的
     *
     * @param string $year 年份 例如2017
     * @param null|int $ditch_id 渠道ID
     * @param null|int $agent_id 代理人ID
     *
     * @return array 返回格式为二维数组，二维键为month和money
     */
    public function getHaveDoneData($year, $ditch_id = null, $agent_id = null)
    {
        $order = new Order();

        if ($ditch_id) {
            $order = $order->where('ditch_id', $ditch_id);
        }
        if ($agent_id) {
            $order = $order->where('agent_id', $agent_id);
        }
        $result = $order
            ->where(DB::raw('DATE_FORMAT(pay_time,"%Y")'), $year)
            ->groupBy(DB::raw('DATE_FORMAT(pay_time,"%m")'))
            ->select(DB::raw('sum(premium) as money'), DB::raw('DATE_FORMAT(pay_time,"%m") as month'))
            ->get()
            ->toArray();

        $result = $this->format($result);

        return $result;
    }

    /**
     * 每月累加
     *
     * @param array $data getHaveDoneData的数据（实际完成的）
     *
     * @return array
     */
    public function getHaveDoneSumData(array $data)
    {
        $result = [];
        $tmp = 0;
        foreach ($data as $item) {
            $tmp += $item['money'];
            $result[] = $tmp;
        }

        return $result;
    }

    /**
     * 数据格式化：填充月份，额度除以100，用于ECharts展示
     *
     * @param array $result
     *
     * @return array
     */
    protected function format(array $result)
    {
        $months = range(1, 12);
        $result_month = [];
        foreach ($result as $key => $item) {
            $result_month[] = (int)$item['month'];
            $result[$key]['month'] = (int)$item['month'];
            $result[$key]['money'] = ceil($item['money']/100);
        }

        // 查出不存在的月份
        $diff_month = array_diff($months, $result_month);
        // 填充
        foreach ($diff_month as $item) {
            $result[] = ['month' => $item, 'money' => 0];
        }
        array_multisort(array_column($result,'month'),SORT_ASC, $result);

        $return = [];
        foreach ($result as &$item) {
            $return[] = $item['money'];
        }
        return $return;
    }
}

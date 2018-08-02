// 折线柱状地图格式
$.get("/backend/statistics",function(data) {
	one(data)
});
function one(data){
	count = data.count;
	premium = data.premium;

	var dataObj1 = {
		xAxisData: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
		legendName: ['保费','件数'],
		yAxisName: ['保费/万','件数/件'],
		series: [{
			name: '保费',
			type: 'line',
			yAxisIndex: 0,
			barWidth: 10,
			data: premium
		},
			{
				name: '件数',
				type: 'line',
				yAxisIndex: 1,
				smooth: true,
				data: count
			}
		]
	}
	lineColumnChart('main1',dataObj1);
}

//累计佣金、件均佣金、人均佣金佣金
$.get("/backend/brokerage",function(data){
	Three(data)
});
	function Three(data){
	a_brokerage = data.a_brokerage;
	brokerage = data.brokerage;
	people = data.people;

var dataObj2 = {
	xAxisData: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	legendName: ['累计佣金','件均佣金','人均佣金'],
	yAxisName: ['佣金/万','累计/万'],
	series: [{
			name: '累计佣金',
			type: 'bar', // 柱状图
			yAxisIndex: 1,
			barWidth: 10,
			data: brokerage
		},
		{
			name: '件均佣金',
			type: 'line', // 折线图
			yAxisIndex: 0,
			smooth: true,
			data: a_brokerage
		},
		{
			name: '人均佣金',
			type: 'line',
			yAxisIndex: 0,
			smooth: true,
			data: people
		}
	]
}
	lineColumnChart('main2',dataObj2);
}


//人均保费、客户数
$.get("/backend/average",function(data){
	five(data);
});
function five(data){
	premium = data.premium;
	count = data.count;
var dataObj3 = {
	xAxisData: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	legendName: ['人均保费','客户数'],
	yAxisName: ['保费/元','客户/个'],
	series: [{
			name: '人均保费',
			type: 'line',
			smooth: true,
			data: premium
		},
		{
			name: '客户数',
			type: 'bar',
			barWidth: 10,
			data: count
		},
	]
}
lineColumnChart('main3',dataObj3);

}

var dataObj4 = {
	xAxisData: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	legendName: ['报案量','结案量'],
	yAxisName: ['数量/个','数量/个'],
	series: [{
			name: '报案量',
			type: 'line',
			smooth: true,
			data: [220, 182, 191, 234, 290, 330, 310, 132, 191, 134, 90, 150]
		},
		{
			name: '结案量',
			type: 'line',
			smooth: true,
			data: [100, 102, 151, 134, 100, 230, 290, 152, 202, 104, 70, 250]
		},
	]
}

//代理人数 、代理人活跃率'
$.get("/backend/agentCount",function(data){
	seven(data);
});
function seven(data){
	count = data.count;
	rate = data.o_count;

var dataObj5 = {
	xAxisData: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	legendName: ['代理人数','代理人活跃率'],
	yAxisName: ['人数/个','活动率/%'],
	series: [{
			name: '代理人数',
			type: 'bar',
			barWidth: 10,
			data: count
		},
		{
			name: '代理人活跃率',
			type: 'line',
			smooth: true,
			data: rate
		},
	]
}
	lineColumnChart('main5',dataObj5);
}

//任务额度、任务达成率
$.get("/backend/indexTask",function(data){
	c_money = data.c_money;
	money = data.money;

var dataObj6 = {
	xAxisData: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
	legendName: ['任务额度','任务达成率'],
	yAxisName: ['任务/万','活动率/%'],
	series: [{
			name: '任务额度',
			type: 'bar',
			barWidth: 10,
			data: money
		},
		{
			name: '任务达成率',
			type: 'line',
			smooth: true,
			data: c_money
		},
	]
}

	lineColumnChart('main6',dataObj6);
});

// 地图数据格式
$.get("/backend/customer",function(data) {
	six(data);
});
function six(data){
	var areaDatas = [];
	$.each(data, function (i, val) {
		var obj = {};
		obj.name = val.name;
		obj.value = val.count;
		areaDatas.push(obj);
	})

	mapChart('main33', areaDatas);

}

// 饼图数据格式
$.get("/backend/safe",function(data) {
	two(data);
});
	function two(data){
	var level1 = [];
	var level2 = [];
	$.each(data['one'], function(i, value) {
		var obj = {};
		obj.name = value.name;
		obj.value = value.one_premium;
		level1.push(obj);
	});

	$.each(data['two'], function(i, value) {
		var obj = {};
		obj.name = value.name;
		obj.value = value.two_premium;
		level2.push(obj);
	});


var pieData1 = {
	level1 : level1,
	level2 : level2
}
	pieChart('main11',pieData1);

};


//佣金饼图
$.get("/backend/PieChart",function(data) {
	Four(data);
});
function Four(data){
	var level1 = [];
	var level2 = [];
	$.each(data['one'], function(i, value) {
		var obj = {};
		obj.name = value.name;
		obj.value = value.one_brokerage;
		level1.push(obj);
	});

	$.each(data['two'], function(i, value) {
		var obj = {};
		obj.name = value.name;
		obj.value = value.two_brokerage;
		level2.push(obj);
	});


	var pieData22 = {
		level1 : level1,
		level2 : level2
	}
	pieChart('main22',pieData22);
}


// 排行榜数据格式
	$.get("/backend/ranking",function(data) {
		name = data.name;
		count = data.count;

	var barData = {
		yAxisData: name,
		xAxisData: count
	}

	transverseBarChart('main55', barData);
})

//lineColumnChart('main2',dataObj2);
//lineColumnChart('main3',dataObj3);
lineColumnChart('main4',dataObj4);
//lineColumnChart('main5',dataObj5);
//lineColumnChart('main6',dataObj6);



//pieChart('main11',pieData1);
//pieChart('main22',pieData22);
//mapChart('main33',areaDatas);
//transverseBarChart('main55',barData);

$('.select-chart .item').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	var index = $(this).index();
	$(this).parents('.chart-wrapper').find('.chart').eq(index).css('visibility','visible').siblings('.chart').css('visibility','hidden');
//	pieChart('main1',pieData1);
});

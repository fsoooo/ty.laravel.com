//地区联动
var Cascade = function(province, city, county) {
	this.provinceEle = province;
	this.cityEle = city;
	this.countyEle = county;
	this.init();
	this.changeProvince();
	this.changeCity();
}
Cascade.prototype = {
	provinceArr: areaData.province,
	cityArr: areaData.city,
	countyArr: areaData.county,
	init: function() {
		var provinceHtml = '';
//		provinceHtml += '<option disabled selected>请选择</option>';
		for(var id in this.provinceArr) {
			provinceHtml += '<option value="' + id + '">' + this.provinceArr[id] + '</option>'
		}
		this.provinceEle.append(provinceHtml);

		var id = this.provinceEle.val();
		this.change(this.cityArr[id], this.cityEle);
		this.change(this.countyArr[this.cityArr[id][0][1]], this.countyEle);
//		if(this.cityArr[id]){
//			this.change(this.countyArr[this.cityArr[id][0][1]], this.countyEle);
//		}else{
//			$('#city,#county').append('<option disabled selected>请选择</option>')
//		}
		
	},
	changeProvince: function() {
		var _this = this;
		this.provinceEle.change(function() {
			var id = $(this).val();
			_this.change(_this.cityArr[id], _this.cityEle);
			_this.change(_this.countyArr[_this.cityArr[id][0][1]], _this.countyEle);
		});
	},
	changeCity: function() {
		var _this = this;
		this.cityEle.change(function() {
			var id = $(this).val();
			_this.change(_this.countyArr[id], _this.countyEle);
		});
	},
	change: function(arr, ele) {
		ele.empty();
		var html = '';
		if(arr){
			for(var i = 0; i < arr.length; i++) {
				html += '<option value="' + arr[i][1] + '">' + arr[i][0] + '</option>'
			}
			ele.append(html);
		}
	}
}

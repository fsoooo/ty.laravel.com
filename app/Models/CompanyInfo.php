<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model{
	protected $table = 'company_info';
	
	public function group_insure()
	{
		$input = $_POST;
	}
}
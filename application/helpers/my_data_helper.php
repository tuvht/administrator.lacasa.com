<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

function structure($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function sortData(&$data = array(), $sortBy, $sortDestination = 'ASC') {
	if (empty($data) || $sortBy == '') {
		return;
	}

	usort(
		$data,
		function ($a, $b) use (&$sortBy, $sortDestination) {
			if ($sortDestination == 'DESC') {
				return $a[$sortBy] < $b[$sortBy];
			}

			return $a[$sortBy] > $b[$sortBy];
		}
	);
}
function create_random_string($num) {
	//Tao du lieu cho hinh ngau nhien
	$chars = array('a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J', 'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T', 'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z',
		'1', '2', '3', '4', '5', '6', '7', '8', '9', '~', '!', '@', '#', '$', '%', '&', '?');
	$max_chars = count($chars)-1;

	for ($i = 0; $i < $num; $i++) {
		$code = ($i == 0)?$chars[rand(0, $max_chars)]:$code.$chars[rand(0, $max_chars)];
	}

	return $code;
}

function dateFormat($dateField, $country = null, $time = 0) {
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	if ($dateField == '') {
		return false;
	}

	$date = strtotime($dateField);

	if ($country == 'VN') {
		$arr = array("Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy");

		if ($time == 1) {
			$datetime = date('d-m-Y, H:i', $date);
		} else {
			$datetime = date('d-m-Y', $date);
		}

		$result = $arr[date('w', $date)].', '.$datetime;
	} else {
		$arr = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

		if ($time == 1) {
			$datetime = date('d-m-Y, H:i', $date);
		} else {
			$datetime = date('F d, Y', $date);
		}

		$result = $datetime;
	}

	return $result;
}

function price($price, $country = null) {
	if ($country == 'VN') {
		$arr = number_format($price, 0, '', '.')." VNĐ";
	} else {
		$arr = '$'.$price;
	}

	return $arr;
}

function alias($str) {
	$search = array(
		'#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
		'#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
		'#(ì|í|ị|ỉ|ĩ)#',
		'#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
		'#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
		'#(ỳ|ý|ỵ|ỷ|ỹ)#',
		'#(đ)#',
		'#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
		'#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
		'#(Ì|Í|Ị|Ỉ|Ĩ)#',
		'#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
		'#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
		'#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
		'#(Đ)#',
		'#(A-Z)#',
		"/[^a-zA-Z0-9.\-\_]/",
	);
	$replace = array('a', 'e', 'i', 'o', 'u', 'y', 'd', 'A', 'E', 'I', 'O', 'U', 'Y', 'D', 'a-z', '-', );
	$str     = preg_replace($search, $replace, $str);
	$str     = preg_replace('/(-)+/', '-', $str);

	return $str;
}

?>
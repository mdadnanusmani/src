<?php

// This class Convert Hijri date to Gregorian Date & vise versa, made by Layth A. Ibraheeim - 24-2-2011
// to test if the results are ok, please visit (http://www.oriold.uzh.ch/static/hegira.html)..

class hijri {
	var $Day;
	var $Month;
	var $Year;
	var $Hday;
	var $Hmonthe;
	var $Hyear;

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/*
	 _j اليوم بدون أصفار
	 _d يوم مع أصفار
	 _z رقم اليوم في السنة
	 _M,_F اسم الشهر
	 _m   رقم الشهر مع أصفار
	 _n رقم الشهر بدون أصفار
	 _t عدد الأيام في الشهر
	 _L السنة كبيسة أم لا 1=كبيسة
	 _Y السنة رقم كامل
	 _y السنة من رقمين
	 ******أحرف تنسيق التاريخ الميلادي التي تم إعادة توجيهها
	 l,D اسم يوم الإسبوع
	 F اسماء الأشهر السريانية (كانون، شباط...)
	 M اسماء الأشهر (تسمية إنجليزية)يناير ، فبراير...)
	 a ,A صباحا ومساء للوقت
	 */

	function adate($format = '_j _M _Yهـ', $timestamp = 0) {
		$gmonths = array("يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر");
		$smonths = array("كانون الثاني", "شباط", "آذار", "نيسان", "أيار", "حزيران", "تموز", "آب", "أيلول", "تشرين الأول", "تشرين الثاني", "كانون الأول");
		$days = array("الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت");
		$hmonths = array("محرم", "صفر", "شهر ربيع الأول", "شهر ربيع الثاني", "جمادى الأولى", "جمادى الآخرة", "رجب", "شعبان", "شهر رمضان", "شوال", "ذو القعدة", "ذو الحجة");

		if ($timestamp == 0) {$timestamp = time();
		}
		list($w, $mn, $am) = explode(' ', date("w n a", $timestamp));
		$j = intval($timestamp / 86400);
		$j = $j + 492150;
		//492534;
		$n = intval($j / 10631);
		$j = $j - ($n * 10631);
		$y = intval($j / 354.36667);
		$hy = ($n * 30) + $y + 1;
		$j = $j - round($y * 354.36667);
		$z = $j;
		$m = intval($j / 29.5);
		$hm = $m + 1;
		$j = $j - round($m * 29.5);
		$d = $j;
		$hd = intval($d);

		If ($hd == 0) {
			$hd = ($hm % 2 == 1) ? (29) : (30);
			$hm = $hm - 1;
		}

		If ($hm == 0) {
			$hm = 12;
			$hy = $hy - 1;
			if (round(($hy % 30) * 0.36667) > round((($hy - 1) % 30) * 0.36667)) {
				$hd = 30;
				$z = 355;
			} else {
				$hd = 29;
				$z = 354;
			}
		}
		$L = (round(($hy % 30) * 0.36667) > round((($hy - 1) % 30) * 0.36667)) ? (1) : (0);
		$str = '';
		for ($n = 0; $n <= strlen($format); $n++) {
			$c = substr($format, $n, 1);
			switch ($c) {
				case "l" :
				case "D" :
					$str .= $days[$w];
					break;
				case "F" :
					$str .= $smonths[($mn - 1)];
					break;
				case "M" :
					$str .= $gmonths[($mn - 1)];
					break;
				case "a" :
					$str .= ($am == 'am') ? ('ص') : ('م');
					break;
				case "A" :
					$str .= ($am == 'AM') ? ('صباحًا') : ('مساءً');
					break;
				case "_" :
					$n = $n + 1;
					switch (substr($format,$n,1)) {
						case "j" :
							$str .= $hd;
							break;
						case "d" :
							$str .= str_pad($hd, 2, "0", STR_PAD_LEFT);
							break;
						case "z" :
							$str .= $z - 1;
							break;
						case "F" :
						case "M" :
							$str .= $hmonths[($hm - 1)];
							break;
						case "t" :
							$t = ($hm % 2 == 1) ? (30) : (29);
							If ($hm == 12 && $L == 1)
								$t = 30;
							$str .= $t;
							break;
						case "m" :
							$str .= str_pad($hm, 2, "0", STR_PAD_LEFT);
							break;
						case "n" :
							$str .= $hm;
							break;
						case "y" :
							$str .= substr($hy, 2);
							break;
						case "Y" :
							$str .= $hy;
							break;
						case "L" :
							$str .= $L;
							break;
					}
					break;
				case '\\' :
					$str .= substr($format, $n, 2);
					$n++;
					break;
				default :
					$str .= $c;
					break;
			}

		}
		return date($str, $timestamp);
	}

	///////////////////////////////////////////
	function hejri2time($thedate) {
		list($hd, $hm, $hy) = preg_split('/[\/\-\.\s\\\\]+/', $thedate);
		$hy = $hy - 1;
		$n = intval($hy / 30);
		$j = ($n * 10631) + round(($hy - ($n * 30)) * 354.36667);
		$hm = $hm - 1;
		$j = $j + round($hm * 29.5) + $hd;
		$j = $j - 492150;
		$jd = $j * 86400;
		return $jd;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function intPart($floatNum) {
		if ($floatNum < -0.0000001) {
			return ceil($floatNum - 0.0000001);
		}
		return floor($floatNum + 0.0000001);
	}

	function ConstractDayMonthYear($date, $format)// extract day, month, year out of the date based on the format.
	{
		$this -> Day = "";
		$this -> Month = "";
		$this -> Year = "";

		$format = strtoupper($format);
		$format_Ar = str_split($format);
		$srcDate_Ar = str_split($date);

		for ($i = 0; $i < count($format_Ar); $i++) {

			switch($format_Ar[$i]) {
				case "D" :
					$this -> Day .= $srcDate_Ar[$i];
					break;
				case "M" :
					$this -> Month .= $srcDate_Ar[$i];
					break;
				case "Y" :
					$this -> Year .= $srcDate_Ar[$i];
					break;
			}
		}

	}

	function HijriToGregorian($date, $format)// $date like 10121400, $format like DDMMYYYY, take date & check if its hijri then convert to gregorian date in format (DD-MM-YYYY), if it gregorian the return empty;
	{
		list($hy, $hm, $hd) = preg_split('/[\/\-\.\s\\\\]+/', $date);

		return date("Y-m-d", $this -> hejri2time($hd . '-' . $hm . '-' . $hy));

		$this -> ConstractDayMonthYear($date, $format);
		$d = intval($this -> Day);
		$m = intval($this -> Month);
		$y = intval($this -> Year);

		if ($y < 1700) {

			$jd = $this -> intPart((11 * $y + 3) / 30) + 354 * $y + 30 * $m - $this -> intPart(($m - 1) / 2) + $d + 1948440 - 385;

			if ($jd > 2299160) {
				$l = $jd + 68569;
				$n = $this -> intPart((4 * $l) / 146097);
				$l = $l - $this -> intPart((146097 * $n + 3) / 4);
				$i = $this -> intPart((4000 * ($l + 1)) / 1461001);
				$l = $l - $this -> intPart((1461 * $i) / 4) + 31;
				$j = $this -> intPart((80 * $l) / 2447);
				$d = $l - $this -> intPart((2447 * $j) / 80);
				$l = $this -> intPart($j / 11);
				$m = $j + 2 - 12 * $l;
				$y = 100 * ($n - 49) + $i + $l;
			} else {
				$j = $jd + 1402;
				$k = $this -> intPart(($j - 1) / 1461);
				$l = $j - 1461 * $k;
				$n = $this -> intPart(($l - 1) / 365) - $this -> intPart($l / 1461);
				$i = $l - 365 * $n + 30;
				$j = $this -> intPart((80 * $i) / 2447);
				$d = $i - $this -> intPart((2447 * $j) / 80);
				$i = $this -> intPart($j / 11);
				$m = $j + 2 - 12 * $i;
				$y = 4 * $k + $n + $i - 4716;
			}

			if ($d < 10)
				$d = "0" . $d;

			if ($m < 10)
				$m = "0" . $m;
			$this->Hday='$d';
			$this->Hmonthe='$m';
			$this->Hyear='$y';
			//return $d."-".$m."-".$y;
			return $y . "-" . $m . "-" . $d;
		} else
			return "";
	}

	function GregorianToHijri($date, $format)// $date like 10122011, $format like DDMMYYYY, take date & check if its gregorian then convert to hijri date in format (DD-MM-YYYY), if it hijri the return empty;
	{
		$this -> ConstractDayMonthYear($date, $format);
		$d = intval($this -> Day);
		$m = intval($this -> Month);
		$y = intval($this -> Year);

		if ($y > 1700) {
			if (($y > 1582) || (($y == 1582) && ($m > 10)) || (($y == 1582) && ($m == 10) && ($d > 14))) {
				$jd = $this -> intPart((1461 * ($y + 4800 + $this -> intPart(($m - 14) / 12))) / 4) + $this -> intPart((367 * ($m - 2 - 12 * ($this -> intPart(($m - 14) / 12)))) / 12) - $this -> intPart((3 * ($this -> intPart(($y + 4900 + $this -> intPart(($m - 14) / 12)) / 100))) / 4) + $d - 32075;
			} else {
				$jd = 367 * $y - $this -> intPart((7 * ($y + 5001 + $this -> intPart(($m - 9) / 7))) / 4) + $this -> intPart((275 * $m) / 9) + $d + 1729777;
			}

			$l = $jd - 1948440 + 10632;
			$n = $this -> intPart(($l - 1) / 10631);
			$l = $l - 10631 * $n + 354;
			$j = ($this -> intPart((10985 - $l) / 5316)) * ($this -> intPart((50 * $l) / 17719)) + ($this -> intPart($l / 5670)) * ($this -> intPart((43 * $l) / 15238));
			$l = $l - ($this -> intPart((30 - $j) / 15)) * ($this -> intPart((17719 * $j) / 50)) - ($this -> intPart($j / 16)) * ($this -> intPart((15238 * $j) / 43)) + 29;
			$m = $this -> intPart((24 * $l) / 709);
			$d = $l - $this -> intPart((709 * $m) / 24);
			$y = 30 * $n + $j - 30;

			if ($d < 10)
				$d = "0" . $d;

			if ($m < 10)
				$m = "0" . $m;

			return $d . "-" . $m . "-" . $y;
		} else
			return "";

	}

	function GregorianToHijri2($date, $format,$type)// $date like 10122011, $format like DDMMYYYY, take date & check if its gregorian then convert to hijri date in format (DD-MM-YYYY), if it hijri the return empty;
	{
		$this -> ConstractDayMonthYear($date, $format);
		$d = intval($this -> Day);
		$m = intval($this -> Month);
		$y = intval($this -> Year);

		if ($y > 1700) {
			if (($y > 1582) || (($y == 1582) && ($m > 10)) || (($y == 1582) && ($m == 10) && ($d > 14))) {
				$jd = $this -> intPart((1461 * ($y + 4800 + $this -> intPart(($m - 14) / 12))) / 4) + $this -> intPart((367 * ($m - 2 - 12 * ($this -> intPart(($m - 14) / 12)))) / 12) - $this -> intPart((3 * ($this -> intPart(($y + 4900 + $this -> intPart(($m - 14) / 12)) / 100))) / 4) + $d - 32075;
			} else {
				$jd = 367 * $y - $this -> intPart((7 * ($y + 5001 + $this -> intPart(($m - 9) / 7))) / 4) + $this -> intPart((275 * $m) / 9) + $d + 1729777;
			}

			$l = $jd - 1948440 + 10632;
			$n = $this -> intPart(($l - 1) / 10631);
			$l = $l - 10631 * $n + 354;
			$j = ($this -> intPart((10985 - $l) / 5316)) * ($this -> intPart((50 * $l) / 17719)) + ($this -> intPart($l / 5670)) * ($this -> intPart((43 * $l) / 15238));
			$l = $l - ($this -> intPart((30 - $j) / 15)) * ($this -> intPart((17719 * $j) / 50)) - ($this -> intPart($j / 16)) * ($this -> intPart((15238 * $j) / 43)) + 29;
			$m = $this -> intPart((24 * $l) / 709);
			$d = $l - $this -> intPart((709 * $m) / 24);
			$y = 30 * $n + $j - 30;

			if ($d < 10)
				$d = "0" . $d;

			if ($m < 10)
				$m = "0" . $m;
			
			return $d . "-" . $m . "-" . $y;
		} else
			return "";

	}	

}

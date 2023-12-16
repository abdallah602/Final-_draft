<?php
	function is_strong($password){
		//اختبار اذا كان كلمه السر تحتوي علي حروف كبيره وصفيره وخاليه من اي رموز
				$Cap    = false;
				$small  = false;
				$nums   = false;
				$count  = 0;
				$num_pass = strlen($password);
				for($i = 0;$i < $num_pass;$i++){
					if((int)($password[$i]) != 0){
						$count+=1;
						$nums = true;
				}else{
						if($password[$i]){
								if(ord($password[$i]) >= 97 && ord($password) <= 122){
									$count+=1;
										$small = true;
								}else if(ord($password[$i]) >= 65 && ord($password[$i]) <= 90){
										$Cap = true;
										$count+=1;
								}
						}else{
								$nums = true;
								$count+=1;
						}
				}
			}//اختبار اذا كان كلمه السر تحتوي علي حروف كبيره وصفيره وخاليه من اي رموز
			return($Cap && $small && $nums && $count === $num_pass);
	}
	function get_str_pass(){
		//لارجاع رقم سري قوي
			$num_rand = rand(3 , 5);
			$pass = "";
			for($i =1;$i <= $num_rand;$i++):
				$num = rand(65 , 122);
				if($num > 90 && $num <97){
					$i--;
			}else{
					$pass .= chr($num);
			}
		endfor;
			$pass .= rand(1 , 999);
			
		for($i =$num_rand+1;$i <= 7;$i++):
			$num = rand(65 , 122);
					if($num > 90 && $num <97){
						$i--;
					}else{
						$pass .= chr($num);
				}
			endfor;
			return $pass;
	}
	function is_mobilephone($phone){
		$num_phone = strlen($phone);
		if($num_phone == 11):
		$number = 0;
		$good   = false;
		
		for($i = 0;$i<$num_phone;$i++){

			if((int)$phone[$i] != 0){
				$number++;
			}else if($phone[$i] === '0'){
				$number++;
			}
		}
		if($phone[0] == 0 && $phone[1] == 1 && 
			$phone[2] == 0 ||$phone[2] == 1||$phone[2] == 2){
				$good = true;
			}
		
		return ($number === $num_phone && $good);
		else:
		return false;
		endif;

	}

	function is_string_true(string $string){
		$number = strlen($string);
		$new = "";
		for ($i = 0;$i<$number;$i++){
				if($string[$i] == "'"){
						$new .= "\\".$string[$i];
				}else{
						$new .= $string[$i];
				}
		}
		return $new;
}
	
?>

function sms($phone,$pass)
{
                $url = "https://mobile.net.sa/sms/gw/";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt ($ch, CURLOPT_HEADER, false);
                curl_setopt ($ch, CURLOPT_POST, true);

                $msg=rand(1,100).'Password is '.$pass;
$dataPOST = array('userName' => 'aseergov', 'userPassword' => '665942', 'userSender' => 'Elmgdad', 'numbers' => $phone, 'msg' => $msg, 'By' => "standard");
                curl_setopt ($ch, CURLOPT_POSTFIELDS, $dataPOST);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLE_HTTP_NOT_FOUND,1);
                $SendingResult = curl_exec ($ch);
                curl_close ($ch);
        //	return $FainalResult;
        /*    if($SendingResult=="1"){
        	echo "تم إرسال الرسالة بنجاح";
        }elseif($SendingResult=="1010"){
        	echo "معلومات ناقصة.. اسم المستخدم أو كلمة المرور أو في محتوى الرسالة أو الرقم";
        }elseif($SendingResult=="1020"){
        	echo "بيانات الدخول خاطئة";
        }elseif($SendingResult=="1030"){
        	echo "نفس الرسالة مع نفس الاتجاه توجد في الملحق، انتظر عشر ثواني قبل إعادة إرسالها";
        }elseif($SendingResult=="1040"){
        	echo "حروف غير معترف بها ";
        }elseif($SendingResult=="1050"){
        	echo "الرسالة فارغة، السبب:الانتقاء قد سبب حذف محتوى الرسالة";
        }elseif($SendingResult=="1060"){
        	echo "اعتماد غير كافي لعميلة الإرسال";
        }elseif($SendingResult=="1070"){
        	echo "رصيدك 0 ، غير كافي لعملية الإرسال";
        }elseif($SendingResult=="1080"){
        	echo "رسالة غير مرسلة ، خطأ في عملية إرسال رسالة";
        }elseif($SendingResult=="1090"){
        	echo "تكرير عملية الانتقاء أنتج الرسالة";
        }elseif($SendingResult=="1100"){
        	echo "عذرا ، لم يتم إرسال الرسالة. حاول في وقت لاحق";
        }elseif($SendingResult=="1110"){
        	echo "عذرا، هناك اسم مرسل خاطئ ثم استعماله، حاول من جديد تصحيح الاسم";
        }elseif($SendingResult=="1120"){
        	echo "عذرا ، هذا البلد الذي تحاول الإرسال له لا تشمله شبكتنا";
        }elseif($SendingResult=="1130"){
        	echo "عذرا، راجع المشرف على شبكاتنا باعتبار الشبكة المحددة في حسابكم";
        }elseif($SendingResult=="1140"){
        	echo "عذرا ، تجاوزت الحد الأقصى لأجزاء الرسائل. حاول إرسال عدد أقل من الأجزاء";
        }elseif($SendingResult=="1150"){
        	echo "هذه الرسالة مكررة بنفس رقم الجوال واسم المرسل ونص الرسالة";
        }elseif($SendingResult=="1160"){
        	echo "هناك مشكلة في مدخلات تاريخ وتوقيت الإرسال اللاحق";
        }else{
        	echo $SendingResult;
        }

            */
}


function sms($rand,$phone)
{
                $url = "https://mobile.net.sa/sms/gw/";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt ($ch, CURLOPT_HEADER, false);
                curl_setopt ($ch, CURLOPT_POST, true);
                $msg='Code is '.$rand;
$dataPOST = array('userName' => 'aseergov', 'userPassword' => '665942', 'userSender' => 'Elmgdad', 'numbers' => $phone, 'msg' => $msg, 'By' => "standard");
                curl_setopt ($ch, CURLOPT_POSTFIELDS, $dataPOST);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLE_HTTP_NOT_FOUND,1);
                $SendingResult = curl_exec ($ch);
                curl_close ($ch);
        //	return $FainalResult;
/*        if($SendingResult=="1"){
        	echo "تم إرسال الرسالة بنجاح";
        }elseif($SendingResult=="1010"){
        	echo "معلومات ناقصة.. اسم المستخدم أو كلمة المرور أو في محتوى الرسالة أو الرقم";
        }elseif($SendingResult=="1020"){
        	echo "بيانات الدخول خاطئة";
        }elseif($SendingResult=="1030"){
        	echo "نفس الرسالة مع نفس الاتجاه توجد في الملحق، انتظر عشر ثواني قبل إعادة إرسالها";
        }elseif($SendingResult=="1040"){
        	echo "حروف غير معترف بها ";
        }elseif($SendingResult=="1050"){
        	echo "الرسالة فارغة، السبب:الانتقاء قد سبب حذف محتوى الرسالة";
        }elseif($SendingResult=="1060"){
        	echo "اعتماد غير كافي لعميلة الإرسال";
        }elseif($SendingResult=="1070"){
        	echo "رصيدك 0 ، غير كافي لعملية الإرسال";
        }elseif($SendingResult=="1080"){
        	echo "رسالة غير مرسلة ، خطأ في عملية إرسال رسالة";
        }elseif($SendingResult=="1090"){
        	echo "تكرير عملية الانتقاء أنتج الرسالة";
        }elseif($SendingResult=="1100"){
        	echo "عذرا ، لم يتم إرسال الرسالة. حاول في وقت لاحق";
        }elseif($SendingResult=="1110"){
        	echo "عذرا، هناك اسم مرسل خاطئ ثم استعماله، حاول من جديد تصحيح الاسم";
        }elseif($SendingResult=="1120"){
        	echo "عذرا ، هذا البلد الذي تحاول الإرسال له لا تشمله شبكتنا";
        }elseif($SendingResult=="1130"){
        	echo "عذرا، راجع المشرف على شبكاتنا باعتبار الشبكة المحددة في حسابكم";
        }elseif($SendingResult=="1140"){
        	echo "عذرا ، تجاوزت الحد الأقصى لأجزاء الرسائل. حاول إرسال عدد أقل من الأجزاء";
        }elseif($SendingResult=="1150"){
        	echo "هذه الرسالة مكررة بنفس رقم الجوال واسم المرسل ونص الرسالة";
        }elseif($SendingResult=="1160"){
        	echo "هناك مشكلة في مدخلات تاريخ وتوقيت الإرسال اللاحق";
        }else{
        	echo $SendingResult;
        }

    */
}

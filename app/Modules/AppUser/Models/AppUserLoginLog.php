<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AppUserLoginLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function ip_visitor_country()
    {

        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=" . $ip);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ip_data_in = curl_exec($ch); // string
        curl_close($ch);

        $ip_data = json_decode($ip_data_in, true);
        $ip_data = str_replace('&quot;', '"', $ip_data);

        return $ip_data;
    }


    public static function getBrowserInfo()
    {
        $browserInfo = array('user_agent' => '', 'browser' => '', 'browser_version' => '', 'os_platform' => '', 'pattern' => '', 'device' => '');

        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $ub = 'Unknown';
        $version = "";
        $platform = 'App';

        $deviceType = 'Desktop';

        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $u_agent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($u_agent, 0, 4))) {

            $deviceType = 'Mobile';
        }

        if ($_SERVER['HTTP_USER_AGENT'] == 'Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.10') {
            $deviceType = 'Tablet';
        }

        if (stristr($_SERVER['HTTP_USER_AGENT'], 'Mozilla/5.0(iPad;')) {
            $deviceType = 'Tablet';
        }

        //$detect = new Mobile_Detect();

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the user agent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'IE';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent) && (!preg_match('/Opera/i', $u_agent) && !preg_match('/OPR/i', $u_agent))) {
            $bname = 'Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent) && (!preg_match('/Opera/i', $u_agent) && !preg_match('/OPR/i', $u_agent))) {
            $bname = 'Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent) || preg_match('/OPR/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        } elseif ((isset($u_agent) && (strpos($u_agent, 'Trident') !== false || strpos($u_agent, 'MSIE') !== false))) {
            $bname = 'Internet Explorer';
            $ub = 'Internet Explorer';
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = @$matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'browser' => $bname,
            'browser_version' => $version,
            'os_platform' => $platform,
            'device' => $deviceType
        );
    }

    public static function storeUserloginlog($user_id, $login_type, $game_id = null)
    {
        date_default_timezone_set('Asia/Dhaka');
        $location = self::ip_visitor_country();
        if (isset($location['geoplugin_status']) && $location['geoplugin_status'] == 200) {
            $region = $location['geoplugin_region'];
            $city = $location['geoplugin_city'];
            $country = $location['geoplugin_countryName'];
            $timezone = $location['geoplugin_timezone'];
            $ip = $location['geoplugin_request'];
        } else {
            $region = 'Unknown';
            $city = 'Unknown';
            $country = 'Unknown';
            $timezone = 'Unknown';
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $browser = self::getBrowserInfo();
        $browser_name = $browser['browser'];
        if (isset($browser['browser_version'])) {
            $browser_version = $browser['browser_version'];
        } else {
            $browser_version = 'Unknown';
        }
        $operating_system = $browser['os_platform'];
        $device_type = $browser['device'];
        $session_id =  Session::getId();

        $MAC = 'Unknown';

        $logModel = new AppUserLoginLog();
        $logModel->login_type = $login_type;
        $logModel->game_id = $game_id;
        $logModel->app_user_id = $user_id;
        $logModel->ip_address = $ip;
        $logModel->session_id = $session_id;
        $logModel->country = $country;
        $logModel->region = $region;
        $logModel->city = $city;
        $logModel->time_zone = $timezone;
        $logModel->browser_name = $browser_name;
        $logModel->browser_version = $browser_version;

        $logModel->mac_address = $MAC;
        $logModel->device_type = $device_type;
        $logModel->operating_system = $operating_system;
        if ($logModel->save()) {
            return true;
        } else {
            return false;
        }
    }
}

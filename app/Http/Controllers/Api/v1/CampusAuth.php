<?php

namespace App\Http\Controllers\Api\v1;

use App\Candidate;  

class CampusAuth 
{
    public function auth() {
        $return = false;
        $APP = [
            'ID'    => 'local.6149ff4c7fcf40.88217011',
            'CODE'  => 'hpSC3PDk3TGpW1tWTqozH67k2JCD9n6ZY00Zp501baj8sNWvFW'
        ];
        //  ЭТАП 1 - авторизация учетной записи в ЛИЧНОМ КАБИНЕТЕ
        //  редирект на страницу авторизации
        //  редирект обратно после успешной авторизации
        if (!isset($_REQUEST['code'])) {
            header('HTTP 302 Found');
            header('Location: https://int.istu.edu/oauth/authorize/?client_id=' . $APP['ID']);
            exit;
        }
        //  ЭТАП 2 - авторизация приложения
        if (isset($_REQUEST['code'])) {
        //  формирование параметров запроса
            $url = implode('&', [
                'https://int.istu.edu/oauth/token/?grant_type=authorization_code',
                'code=' . $_REQUEST['code'],
                'client_id=' . $APP['ID'],
                'client_secret=' . $APP['CODE']
            ]);
            //  выполнение запроса и обработка ответа
            $data = @file_get_contents($url);
            if (explode(' ', $http_response_header[0])[1] !== '200') return false;
            $data = json_decode($data, true);
        }
        //  ЭТАП 3 - запрос данных по учетной записи
        if (isset($data['client_endpoint']) && isset($data['access_token'])) {
            //  формирование параметров запроса
            $url = $data['client_endpoint'] . 'user.info.json?auth=' . $data['access_token'];
            //  выполнение запроса и обработка ответа
            $data = @file_get_contents($url);
            if (explode(' ', $http_response_header[0])[1] !== '200') return false;
            $data = json_decode($data, true);
            //  проверка наличия структуры данных
            if (isset($data['result']['email'])) $return = $data['result'];
        }

        //работа с пользователями
        $numz = $return['data_student']['nomz'];
        $user = Candidate::where('numz', $numz)->limit(1)->get();
        $fio = $return['last_name'] . ' ' . $return['name'] . ' ' . $return['second_name'];
        
        if ($user->count() == 0) {
            Candidate::create([
                'fio' => $fio,
                'email' => $return['email'],
                'numz' => $numz,
                'phone' => '',
                'about' => '',
                'competencies' => '',
                'course' => 3,
                'training_group' => $return['data_student']['grup'],
                'experience' => '',
                'is_watched' => 0,
            ]);
        } else {
            Candidate::where('numz', $numz)->limit(1)->update([
                'fio' => $fio, 
                'email' => $return['email'],
                'course' => 3,
                'training_group' => $return['data_student']['grup'],
                'is_watched' => 0,
            ]);
        }

        //return $return;
        return redirect('/');
    }
}
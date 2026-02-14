<?php

return [

    'required' => ':attribute は必須です。',
    'min' => [
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],
    'image' => ':attribute は画像ファイルを選択してください。',
    'mimes' => ':attribute は :values 形式のファイルのみ対応しています。',
    'regex' => ':attribute の形式が正しくありません。',

    'attributes' => [
        'profile_image' => 'プロフィール画像',
        'name' => 'ユーザー名',
        'postcode' => '郵便番号',
        'address' => '住所',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
    ],
];

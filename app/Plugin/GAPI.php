<?php

namespace App\Plugin;

class GAPI {
 
	private $private_key = <<<EOD
-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCibjDQ0UmLiQUl
1g9t1uOMW4ZIiqBfG73AaresZCPw095lYHvzqGyjGwD/vkMpAeZ+gdKVF6xEmoWL
H3bdISnAymrbpqF+VD20mPNaoPc8Mac5WK05Sk5N0mI/O++8p+Cb/Gl9Kff9KNE9
P5UpByoimyjYL5VoaXVGhJOxu9Wu9z08DQlYbtxpJ5nb697yOfLjVxXxVXVyfP6x
RstwAdMi90YiL1Oeb36PNu2gcyXjBwVa2uXtXNFBH0WTxk1k1f6TzLl6PEwNMvpm
zxlvjMxeSsPLgHQurHhTLHqgh9SilTQcxG3RA6U0gmIeW0PcLf84Jw+Z6YjrgcgZ
82KsRx4hAgMBAAECggEAYAUvymHOTjRj3KgcWtxLi++XBE8e2tp1Y8gyaDCSpo04
zUkqPTH1dr5B6u04modLEMICEKz741pNU574D2TJX/TJEqwAj8OQ7q/0PEEnpmfb
6SSo0lNA0vRpq+PspuO+/bdLTPiAZyG3/7MUpDpeCDMdBB+s/RpKf7Nj9A+MFG+R
syzA7MPz05gt/uZ/OFjv2O8EH4xGNsmAF0osVKzTJPSuThsLeEf9JpKZ1ZMQ3quK
RXktwzJnSVhFVgBYW4g/zxQmHMGV4ZrEGtILGEA+5kmpWyhUlVkQIs8iuSow7D8D
1u8FHYk3+yOsVQ/DD0pnNebXmj01E5T4MSSa6e8tIQKBgQD5nmDO/hKD5MLLpw+i
Fv9giAZEzZwA0jKk+W+d38QZ4jXXJsuF5mQnAAqpewKZ1hICvEN1Ls9EH9VTsp+W
VNQKWfXRopMBT8E7Bm2mWqo+bfs9mBOT9Lv2jtTQAm8+GGfUplhzZxmkDCJx71hH
+ny+Fyhqd2anBzjIKE52yN5KLQKBgQCmlTY2MXc8VMqAowXGDjNQpkF+OJAXm4V/
cYt7OeHt1uLmf7xI+OxlD9rr2fjxUuDWQtovNJ7LY/pUUikDIeyMjcJOzKeYnKOL
xa1won6tIyXAgLnAv7J9RkUniv5Qliaopq36Cj5xQBX8rkcOjGA2fQBn8HVT4nKo
LZyK16WgRQKBgQC8y60s4b3fRAaRQanxTrOYr0kOgPSdKl5jqMVjAvuvGAjg0dbd
T4QwezeVOBSfhenZZ8sdtmnNfMY8p71MVpyJt8DU7cGCHHBp1FLan3hj/4sm6v7j
yRbhROZw7WZ18L+Xdrkvj6s1CHiE9CIxTqNKovlOjUB21F9+A/5UmViHgQKBgBBP
keRSiZtFriJUVA9leo7OCKGkRi+ZkcO9yWuCamXQYZ0yKqx2eycWG1h2mlJ+y/cO
yrBOlbHSk0NIXC2rV68Xfkwa69oclELuUyIxNvga9epYcFe4LXDovYK2sFoRqa1f
zK8r65tJLB32rox1IEKVkMGcoNBa3uEqviY2IUiFAoGAXmc4jB7KAIxilHVCv4GL
HuwqNBX8uPKzyZhZhaIVTwR9JL46FHFroLMbqD+N/kxY9oXGr7KuC7Rxockn5AAZ
Ece3zAh6MRzcu7BlmdfP99pck+ieVW86uCORtqIDmu7Jc8IbsJ7G8HwKSE7u687o
87ApwYy/HR57G215+oxgPFU=
-----END PRIVATE KEY-----
EOD;

    private $serviceAccountID = 'test-934@api-project-238572195029.iam.gserviceaccount.com';
 
	public function __construct() {
 
	}
    
    public function getAccessToken()
    {
        $access_token = \DB::table('gapi')->where('obj_type', 'access_token')->first();
        try {
            $client = new \GuzzleHttp\Client([]);
            $url = "https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=".$access_token->obj_content;
            $getResponse = $client->request('GET', $url, [
                'form_params' => [
                ]
            ]);
            return $access_token->obj_content;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->getResponse()->getStatusCode() == '400') {
                $time = time();
                $time2 = $time + 3600;
                $header = rtrim(strtr(base64_encode('{"alg":"RS256","typ":"JWT"}'), '+/', '-_'), '=');
                $claims = rtrim(strtr(base64_encode(('{
                  "iss":"test-934@api-project-238572195029.iam.gserviceaccount.com",
                  "scope":"https://www.googleapis.com/auth/analytics.readonly",
                  "aud":"https://www.googleapis.com/oauth2/v4/token",
                  "exp":'.$time2.',
                  "iat":'.$time.'
                }')), '+/', '-_'), '=');
                $data = $header.".".$claims;
                $signature_alg = "sha256WithRSAEncryption";
                openssl_sign ( $data , $signature , $this->private_key , $signature_alg );
                $sign = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
                $result = $header.".".$claims.".".$sign;
                
                $client = new \GuzzleHttp\Client([]);
                $url = "https://www.googleapis.com/oauth2/v4/token";
                $getResponse = $client->request('POST', $url, [
                    'form_params' => [
                        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                        'assertion' => $result
                    ]
                ]);
                $body = $getResponse->getBody();
                $answers = json_decode($body, true);
                \DB::table('gapi')->where('obj_type', 'access_token')->update(array('obj_content' => $answers['access_token']));
                return $answers['access_token'];
            }
        }
    }
}
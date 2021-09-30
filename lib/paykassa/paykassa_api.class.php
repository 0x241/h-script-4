<?php
    class PayKassaAPI {
        public $version = "0.4";
        public function __construct ($api_id, $api_key)  {
            $this->domain = $_SERVER['SERVER_NAME'];
            $this->params = [];
            $this->params["api_id"] = $api_id;
            $this->params["api_key"] = $api_key;
            $this->params["domain"] = $this->domain;

            $this->url = "https://paykassa.pro/api/".$this->version."/index.php";
        }

        public function post_json_request($url, $data=[]) {
            $postdata = http_build_query($data);
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $context  = stream_context_create($opts);
            return json_decode(file_get_contents($url, false, $context), true);
        }

        private function query($url, $data=[]) {
            $result = $this->post_json_request($url, $data + $this->params);
            if ($result === false || $result === null) {
                return [
                    "error" => true,
                    "message" => "Ошибка запроса к сервису!",
                ];
            }
            return $result;
        }

        public function api_get_shop_balance($shop) {
            $fields = ["shop", ];
            return $this->query($this->url, [
                "func" => "api_get_shop_balance",
            ] + compact($fields));
        }

        public function api_payment($shop, $system, $number, $amount, $currency, $comment, $paid_commission='') {
            $fields = ["shop", "system", "number", "amount", "currency", "comment", "paid_commission"];
            return $this->query($this->url, [
                "func" => "api_payment",
            ] + compact($fields));
        }

        public function api_payment_within($shop, $system, $amount, $currency, $comment, $paid_commission='') {
            $fields = ["shop", "system", "amount", "currency", "comment", "paid_commission"];
            return $this->query($this->url, [
                "func" => "api_payment_within",
            ] + compact($fields));
        }

        public function alert($message) { ?>
            <script>window.alert("<?php echo $message; ?>");</script>
        <?php
        }

        public function format_currency($money, $currency) {
            if (strtolower($currency) === "btc") {
                return format_btc($money);
            }
            return format_money($money);
        }

        public function format_btc($money) {
            return sprintf("%01.8f", $money);
        }

        public function format_money($money) {
            return sprintf("%01.2f", $money);
        }

        public function post($key, $value=false) {
            if ($value) {
                $_POST[$key] = $value;
            }
            return isset($_POST[(string)$key]) ? $_POST[(string)$key] : "";
        }

        public function get($key, $value=false) {
            if ($value) {
                $_GET[$key] = $value;
            }
            return isset($_GET[(string)$key]) ? $_GET[(string)$key] : "";
        }

        public function request($key, $value=false) {
            if ($value) {
                $_REQUEST[$key] = $value;
            }
            return isset($_REQUEST[(string)$key]) ? $_REQUEST[(string)$key] : "";
        }
    }

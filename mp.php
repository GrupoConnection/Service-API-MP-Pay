# SOMENTE PARA QUEM TEM ACESSO AOS SERVIDORES HEART PARA PEGAR O RESTO DO MÓDULO, ASS. Willian (CEO. Heart) #


function mercadopago_config()
{

    global $CONFIG;
    $configarray = array(
        "FriendlyName" => array(
            "Type" => "System",
            "Value" => "MercadoPago"
        ),

        "desc-1" => array(
            "FriendlyName" => "Informações Mercado Pago",
            "Description" => "| São necessárias informações do Mercado Pago, Pegue em <a href='https://www.mercadopago.com.br/settings/account/credentials?code=C1cWshK7FAnW8X60mKSKLSR0qU2TckTp' target='_blank'>Credencial</a>|"
        ),

        "client_id" => array(
            "FriendlyName" => "Client ID",
            "Type" => "text",
            "Size" => "40",

        ),

        "client_secret" => array(
            "FriendlyName" => "Client Secret",
            "Type" => "text",
            "Size" => "40",           
        ),

        "mp-mode" => array(
            "FriendlyName" => "Modelo de Abertura",
            "Type" => "dropdown",
            "Options" => "Mesma Pagina,Nova Pagina,Pagina POP,Pagina LightBox",
            "Size" => "30",
            "Description" => "Modo para abrir o processo do pagamento."
        ),


        "auto_window" => array(
            "FriendlyName" => "Abrir Pagina de Pagamento",
            "Type" => "yesno",

            "Description" => "Abrir Pagina de pagamento automaticamente ao acessar a fatura."

        ),        


        "btn_pg_norec" => array(
            "FriendlyName" => "Texto Botão Para Pagamento",
            "Type" => "text",
            "Size" => "30",
            "Default" => "Pagamento"

        ),

        "taxa_percentual" => array(

            "FriendlyName" => "Taxa Porcento (%)",

            "Type" => "text",

            "Size" => "10",

            "Description" => "Taxa para adicionar; fatura. Ex: 5 (igual a 5%). O total ser&aacute; somando com a taxa auxiliar, se houver."

        ),

        "taxa_auxiliar" => array(

            "FriendlyName" => "Taxa Auxiliar",

            "Type" => "text",

            "Size" => "10",

            "Description" => "Valor fixo adicional para a fatura. Ex: 0.50 ou 1.00"

        ),

        "estilo" => array(

            "FriendlyName" => "-- Op&ccedil;&otilde;es de CSS",

            "Description" => "(n&atilde;o altere se n&atilde;o tiver certeza.) --"

        ),

        "btn_css" => array(

            "FriendlyName" => "Classe CSS do Bot&atilde;o de Pagamento",

            "Type" => "text",

            "Size" => "30",

            "Default" => "blue-s-rn-tr"

        ),

        "custom_css" => array(

            "FriendlyName" => "CSS Personalizado",

            "Type" => "textarea",

            "Rows" => "5"

        ),

        "Link P/User" => array(
            "Type" => "System",
            "Value" => "Após a configuração use o link para notificar <b>" . $CONFIG["SystemURL"] . "/modules/gateways/callback/mercadopago.php</b> - Use URL em sua conta MercadoPago <a href='https://www.mercadopago.com/mlb/ferramentas/notificacoes' target='_blank'>Brasil</a>."

        )

    );

    return $configarray;
}



function mercadopago_link($params)

{



    $taxa_percentual = ($params['amount'] / 100) * $params['taxa_percentual'];

    $taxa_total = $taxa_percentual + $params['taxa_auxiliar'];

    $valor_total = $params['amount'] + $taxa_total;

    $valor_total = number_format($valor_total, 2, '.', '');



    $dados = array("sponsor_id" => "131701457", "external_reference" => $params["invoiceid"], "currency" => $params["currency"], "title" => $params["description"], "description" => $params["description"], "quantity" => 1, "image" => "https://www.mercadopago.com/org-img/MP3/home/logomp3.gif", "amount" => (float) $valor_total, "payment_firstname" => $params["clientdetails"]["firstname"], "payment_lastname" => $params["clientdetails"]["lastname"], "email" => $params["clientdetails"]["email"], "pending" => $params["systemurl"] . "/viewinvoice.php?id=" . $params["invoiceid"] . "&pending=true", "approved" => $params["systemurl"] . "/viewinvoice.php?id=" . $params["invoiceid"] . "&success=true");

    $exclude = "";

    $type = "initpoint";

    $pagamento = new mpCore($params["client_id"], $params["client_secret"]);

    $retorno1 = $pagamento->GetCheckout($dados, $exclude, $type);

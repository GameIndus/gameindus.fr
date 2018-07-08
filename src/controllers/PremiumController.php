<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

require("core/Paypal.php");

class PremiumController extends Controller
{

    public function index()
    {
        $this->setTitle('Devenez premium"');
        $this->setDescription('Devenez premium sur GameIndus afin d\'avoir plus de fonctionnalités. De nombreuses surprises vous attendent !');
    }

    public function proceed()
    {
        privatePage(true);
        $user = getUser();

        // if (isPremium($user)) Config::$hideBreadcrumb[] = "premium/proceed"; TODO
        $paypal = new Paypal($this->config->paypal);

        $paypalRequest = $paypal->request("SetExpressCheckout", array(
            "RETURNURL" => "https://gameindus.fr/premium/process",
            "CANCELURL" => "https://gameindus.fr/premium/cancel",

            "PAYMENTREQUEST_0_AMT" => 2.39,
            "PAYMENTREQUEST_0_CURRENCYCODE" => "EUR",
            "PAYMENTREQUEST_0_SHIPPINGAMT" => 0.00,
            "PAYMENTREQUEST_0_ITEMAMT" => 2.39,

            "L_PAYMENTREQUEST_0_NAME0" => "GameIndus Premium",
            "L_PAYMENTREQUEST_0_DESC0" => "Abonnement Premium sur GameIndus.fr pour 1 mois",
            "L_PAYMENTREQUEST_0_AMT0" => 2.39,
            "L_PAYMENTREQUEST_0_QTY0" => 1
        ));

        $user->paypalLink = "https://www.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=" . $paypalRequest["TOKEN"];

        $this->set($user);
    }

    public function renew()
    {
        privatePage();
        $this->setTitle('Renouveler mon abonnement Premium');

        $user = getUser();

        $user->daysRemaining = floor(remainingTimePremium($user) / 60 / 60 / 24);

        $daysRe = ($user->daysRemaining > 31) ? 31 : $user->daysRemaining;
        $user->premiumState = ceil($daysRe * 10 / 31);

        $this->set($user);
    }

    public function process()
    {
        privatePage(true);
        if (!isset($_GET["token"]) || !isset($_GET["PayerID"])) {
            redirect("/");
        }

        $paypal = new Paypal($this->config->paypal);
        $user = getUser();

        $res = $paypal->request("GetExpressCheckoutDetails", array(
            "TOKEN" => $_GET["token"]
        ));

        if ($res) {
            if ($res["CHECKOUTSTATUS"] == "PaymentActionCompleted") {
                setNotif("Ce paiement a déjà été validé.", "danger");
                redirect("/premium/cancel");
            }

            $response = $paypal->request("doExpressCheckoutPayment", array(
                "TOKEN" => $_GET["token"],
                "PAYERID" => $_GET["PayerID"],
                "PAYMENTACTION" => "Sale",
                // "PAYMENTACTION" => "Order",

                "PAYMENTREQUEST_0_AMT" => $res["PAYMENTREQUEST_0_AMT"],
                "PAYMENTREQUEST_0_CURRENCYCODE" => "EUR",

                "L_PAYMENTREQUEST_0_NAME0" => "GameIndus Premium",
                "L_PAYMENTREQUEST_0_DESC0" => "Abonnement Premium sur GameIndus.fr pour 1 mois",
                "L_PAYMENTREQUEST_0_AMT0" => 2.39,
                "L_PAYMENTREQUEST_0_QTY0" => 1
            ));

            if ($response) {
                if ($response["ACK"] == "Success" && $response["PAYMENTINFO_0_ACK"] == "Success") {
                    $this->DB->save(array(
                        "insert" => true,
                        "table" => "users_transactions",
                        "fields" => array(
                            "product" => "GameIndus Premium 1 mois",
                            "ordertime" => date("Y-m-d H:i:s", strtotime($response["PAYMENTINFO_0_ORDERTIME"])),
                            "user_id" => $user->id,
                            "transaction_id" => $response["PAYMENTINFO_0_TRANSACTIONID"],
                            "payer_id" => $_GET["PayerID"]
                        )
                    ));

                    $time = ($user->premium_finish_date != null) ? strtotime($user->premium_finish_date) : time();
                    if ($time < time()) $time = time();

                    $calculatedDate = date("Y-m-d H:i:s", strtotime("+1 month", $time));

                    $email = $user->email;
                    if ($user->activated_with_premium && !$user->active) {
                        $message = "
							Bienvenue sur GameIndus, " . $user->username . " !<br><br>
							Cette adresse e-mail a été utilisée pour la création d'un compte au service de GameIndus (disponible à cette adresse: <a href='http://gameindus.fr/'>https://gameindus.fr/</a>).<br>
							Si ce n'est pas le cas, merci d'ignorer ce message : nous nous excusons de la gène occasionnée.<br>
							<br>
							Nous vous souhaitons la bienvenue sur notre plateforme de création de jeux vidéo en ligne ! Nous vous remercions d'avoir créé un compte sur notre site internet et d'avoir acheté un abonnement premium d'une période d'un mois. Vous avez accès au récapitulatif de votre commande <a href='https://gameindus.fr/premium/order/" . $this->DB->getLastID() . "'>ici</a> (https://gameindus.fr/premium/order/" . $this->DB->getLastID() . ").
							<br>
							En espérant vous revoir bientôt sur GameIndus ! L'équipe vous souhaite une très bonne création de jeux vidéo.
						";
                        emailTemplate($email, $message, 'Bienvenue sur GameIndus !', 'noreply');
                    } else {
                        $message = "
							Bonjour, " . $user->username . " !<br><br>
							Félicitations ! Vous venez de souscrire à un abonnement premium sur notre plateforme. Merci beaucoup de votre soutien !
							<br>
							Vous avez accès au récapitulatif de votre commande <a href='https://gameindus.fr/premium/order/" . $this->DB->getLastID() . "'>ici</a> (https://gameindus.fr/premium/order/" . $this->DB->getLastID() . ").
							<br>
							En espérant vous revoir bientôt sur GameIndus ! L'équipe vous souhaite une très bonne création de jeux vidéo.
						";
                        emailTemplate($email, $message, 'Merci de votre fidélité !', 'noreply');
                    }

                    $this->DB->save(array(
                        "insert" => false,
                        "table" => "users",
                        "fields" => array(
                            "premium" => 1,
                            "premium_finish_date" => $calculatedDate,
                            "active" => 1
                        ),
                        "where" => "id",
                        "wherevalue" => $user->id
                    ));
                    getUser()->active = true;
                    getUser()->premium = true;
                    getUser()->premium_finish_date = $calculatedDate;

                    getUser()->successPremium = true;
                    redirect("/premium/finish");
                } else {
                    setNotif("Une erreur est survenue lors du paiement, et aucun prélèvement n'a été effectué.", "danger");
                    redirect("/premium/cancel");
                }
            } else {
                setNotif("Une erreur est survenue lors du paiement, et aucun prélèvement n'a été effectué.", "danger");
                redirect("/premium/cancel");
            }
        } else {
            setNotif("Une erreur est survenue lors du paiement, et aucun prélèvement n'a été effectué.", "danger");
            redirect("/premium/cancel");
        }

        die();
    }

    public function cancel()
    {

    }

    public function finish()
    {
        privatePage(true);
        if (!getUser()->successPremium) {
            redirect("/account");
        }
        getUser()->successPremium = false;
    }

    public function orders()
    {
        privatePage();
        $user = getUser();

        $user->orders = $this->DB->find(array(
            "table" => "users_transactions",
            "conditions" => array("user_id" => $user->id)
        ));

        $this->set($user);
    }

    public function order($id)
    {
        privatePage();
        $user = getUser();
        $order = $this->DB->findFirst(array("table" => "users_transactions", "conditions" => array(
            "user_id" => $user->id, "id" => $id
        )));

        if (empty($order)) {
            redirect("/account");
            exit();
        }

        require("core/libs/fpdf/fpdf.php");
        require("core/libs/pdf.php");

        $pdf = new PDF();
        $pdf->SetAuthor("GameIndus");
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetDisplayMode("fullpage", "single");
        $pdf->SetTitle("GameIndus | Détails de la commande " . str_pad($order->id, 6, "0", STR_PAD_LEFT), true);
        $pdf->SetSubject("Détails de commande GameIndus.", true);

        function FancyTable($pdf, $header, $data)
        {
            // Couleurs, épaisseur du trait et police grasse
            $pdf->SetFillColor(204, 204, 204);
            $pdf->SetTextColor(0);
            $pdf->SetDrawColor(128, 0, 0);
            $pdf->SetLineWidth(.3);
            $pdf->SetFont('', '');
            // En-tête
            $w = array(70, 20, 35, 30, 35);
            for ($i = 0; $i < count($header); $i++)
                $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            $pdf->Ln();
            // Restauration des couleurs et de la police
            $pdf->SetFillColor(224, 235, 255);
            $pdf->SetTextColor(0);
            $pdf->SetFont('');
            // Données
            $fill = false;
            foreach ($data as $row) {
                $pdf->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
                $pdf->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
                $pdf->Cell($w[2], 6, $row[2], 'LR', 0, 'L', $fill);
                $pdf->Cell($w[3], 6, $row[3], 'LR', 0, 'L', $fill);
                $pdf->Cell($w[4], 6, $row[4], 'LR', 0, 'L', $fill);
                $pdf->Ln();
                $fill = !$fill;
            }
            // Trait de terminaison
            $pdf->Cell(array_sum($w), 0, '', 'T');
        }

        // Header
        $pdf->SetFillColor(243, 244, 248);
        $pdf->Rect(0, 0, 2000, 35, "F");
        $pdf->SetFillColor(221, 221, 221);
        $pdf->Rect(0, 34, 2000, 2, "F");
        $pdf->Image('https://gameindus.fr/imgs/logo/logo-medium.png', 10, 6, 100);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Text(178, 16, 'gameindus.fr');
        $pdf->Text(160, 22, 'contact@gameindus.fr');

        // Details of order
        $pdf->SetFont('Arial', 'b', 16);
        $pdf->Text(65, 62, 'DETAILS DE LA COMMANDE');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Text(10, 75, utf8_decode('Numéro: ') . str_pad($order->id, 6, "0", STR_PAD_LEFT));
        $pdf->Text(10, 80, 'Date de paiement: ' . utf8_decode(date("d/m/Y", strtotime($order->ordertime)) . " à " . date("H:i:s", strtotime($order->ordertime))));

        $pdf->SetXY(10, 90);
        FancyTable(
            $pdf,
            array("Produit", utf8_decode("Quantité"), "Prix HT", "TVA (20%)", "Prix TTC"),
            array(array($order->product, 1, 1.99, 0.40, 2.39), array("", "", "", "", ""), array("", "", "", "", ""), array("", "", "", "", ""), array("Total", "", "1.99 euro", "0.4 euro", "2.39 euros"))
        );

        $pdf->SetFont('Arial', 'b', 16);
        $pdf->Text(60, 150, 'DETAILS DE LA TRANSACTION');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Text(10, 163, utf8_decode('Service de paiement: ') . "Paypal");
        $pdf->Text(10, 173, utf8_decode('ID Client: ') . $order->payer_id);
        $pdf->Text(10, 178, utf8_decode('ID Transaction: ') . $order->transaction_id);
        $pdf->Text(10, 183, utf8_decode('Monnaie utilisée: ') . "EUR (Euro)");
        $pdf->Text(110, 163, utf8_decode('Pseudo de l\'acheteur: ') . $user->username);
        $pdf->Text(110, 168, utf8_decode('E-mail de l\'acheteur: ') . $user->email);
        $pdf->SetFont('Arial', 'b', 13);
        $pdf->Text(110, 180, utf8_decode('FACTURE PAYÉE'));
        $pdf->SetFont('Arial', '', 11);


        $pdf->SetFont('Arial', '', 9);
        $pdf->Text(10, 266, utf8_decode("* Conformément à la loi du 6 janvier 1978, vous disposez d'un droit d'accès, de rectification"));
        $pdf->Text(10, 269, utf8_decode("et d'opposition aux informations nominatives et aux données personnelles vous concernant, directement sur le site Internet."));

        $pdf->Text(10, 275, utf8_decode("** Conformément aux dispositions de l'article L.121-21 du Code de la Consommation,"));
        $pdf->Text(10, 278, utf8_decode("vous disposez d'un délai de rétractation de 14 jours à compter de la réception de vos produits."));


        // Footer
        $pdf->SetAutoPageBreak(false, 10);
        $pdf->SetY(-15);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 0, 'C');

        $pdf->Output();


        $this->set($user);
    }

}

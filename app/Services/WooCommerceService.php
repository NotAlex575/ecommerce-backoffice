<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WooCommerceService
{
    // Recupera gli ordini da WooCommerce tramite API REST
    public function getProcessingOrders(): array
    {
        // Recupero delle chiavi API dal file .env
        $ck = env('WC_CONSUMER_KEY');
        $cs = env('WC_CONSUMER_SECRET');

        // Endpoint WooCommerce per il recupero degli ordini
        $url = env('WC_BASE_URL') . '/wp-json/wc/v3/orders';

        // Parametri OAuth necessari per autenticare la richiesta
        // Il filtro status può essere riattivato per recuperare solo gli ordini processing
        $params = [
            // 'status' => 'processing',
            'oauth_consumer_key' => $ck,
            'oauth_nonce' => bin2hex(random_bytes(8)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
        ];

        // Ordinamento dei parametri richiesto per generare correttamente la firma OAuth
        ksort($params);

        // Creazione della stringa base usata per firmare la richiesta GET
        $baseString = 'GET&'
            . rawurlencode($url)
            . '&'
            . rawurlencode(http_build_query($params, '', '&', PHP_QUERY_RFC3986));

        // Creazione della chiave di firma a partire dal Consumer Secret
        $signingKey = rawurlencode($cs) . '&';

        // Generazione della firma OAuth con algoritmo HMAC-SHA1
        $params['oauth_signature'] = base64_encode(
            hash_hmac('sha1', $baseString, $signingKey, true)
        );

        // Creazione dell’URL finale con tutti i parametri OAuth
        $finalUrl = $url . '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        // Chiamata HTTP verso le API WooCommerce
        $response = file_get_contents($finalUrl);

        // Conversione della risposta JSON in array associativo PHP
        return json_decode($response, true);
    }

    // Recupera il dettaglio di un singolo ordine WooCommerce tramite il suo ID
    public function getOrderById($orderId): array
    {
        // Recupero delle chiavi API dal file .env
        $ck = env('WC_CONSUMER_KEY');
        $cs = env('WC_CONSUMER_SECRET');

        // Endpoint WooCommerce del singolo ordine
        $url = env('WC_BASE_URL') . "/wp-json/wc/v3/orders/$orderId";

        // Parametri OAuth necessari per autenticare la richiesta
        $params = [
            'oauth_consumer_key' => $ck,
            'oauth_nonce' => bin2hex(random_bytes(8)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
        ];

        // Ordinamento dei parametri prima della firma
        ksort($params);

        // Creazione della stringa base per firmare la richiesta GET
        $baseString = 'GET&'
            . rawurlencode($url)
            . '&'
            . rawurlencode(http_build_query($params, '', '&', PHP_QUERY_RFC3986));

        // Chiave usata per firmare la richiesta
        $signingKey = rawurlencode($cs) . '&';

        // Generazione della firma OAuth
        $params['oauth_signature'] = base64_encode(
            hash_hmac('sha1', $baseString, $signingKey, true)
        );

        // URL finale firmato
        $finalUrl = $url . '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        // Chiamata HTTP tramite client Laravel
        $response = Http::get($finalUrl);

        // Conversione della risposta JSON in array PHP
        return $response->json() ?? [];
    }

    // Aggiorna lo stato di un ordine su WooCommerce
    public function updateOrderStatus($orderId, $status): array
    {
        // Recupero delle chiavi API dal file .env
        $ck = env('WC_CONSUMER_KEY');
        $cs = env('WC_CONSUMER_SECRET');

        // Endpoint WooCommerce del singolo ordine da aggiornare
        $url = env('WC_BASE_URL') . "/wp-json/wc/v3/orders/$orderId";

        // Parametri OAuth necessari per autenticare la richiesta PUT
        $params = [
            'oauth_consumer_key' => $ck,
            'oauth_nonce' => bin2hex(random_bytes(8)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
        ];

        // Ordinamento dei parametri prima della firma
        ksort($params);

        // Creazione della stringa base per firmare la richiesta PUT
        $baseString = 'PUT&'
            . rawurlencode($url)
            . '&'
            . rawurlencode(http_build_query($params, '', '&', PHP_QUERY_RFC3986));

        // Chiave usata per generare la firma OAuth
        $signingKey = rawurlencode($cs) . '&';

        // Generazione della firma OAuth
        $params['oauth_signature'] = base64_encode(
            hash_hmac('sha1', $baseString, $signingKey, true)
        );

        // URL finale firmato
        $finalUrl = $url . '?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);

        // Chiamata PUT verso WooCommerce per aggiornare lo stato dell’ordine
        $response = Http::put($finalUrl, [
            'status' => $status,
        ]);

        // Controllo temporaneo degli errori API
        // In produzione si potrebbe sostituire con una gestione tramite log o eccezioni
        if (!$response->successful()) {
            dd($response->status(), $response->body());
        }

        // Conversione della risposta JSON in array PHP
        return $response->json() ?? [];
    }
}
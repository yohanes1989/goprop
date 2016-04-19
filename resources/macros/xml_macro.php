<?php
Response::macro('xml', function(array $vars, $status = 200, array $header = [], $rootElement = 'response', $xml = null, $overrideRoot = null)
{
    if (is_object($vars) && $vars instanceof \Illuminate\Contracts\Support\Arrayable) {
        $vars = $vars->toArray();
    }

    $isRoot = is_null($xml);

    if ($isRoot) {
        $root = !empty($overrideRoot)?$overrideRoot:$rootElement;

        $xml = new SimpleXMLElement('<' . $root. '/>');
    }
    foreach ($vars as $key => $value) {
        if (is_array($value)) {
            if (is_numeric($key)) {
                Response::xml($value, $status, $header, $rootElement, $xml->addChild(str_singular(($isRoot?$rootElement:$xml->getName()))));
            } else {
                Response::xml($value, $status, $header, $rootElement, $xml->addChild($key));
            }
        } else {
            $xml->addChild($key, htmlspecialchars($value));
        }
    }
    if (empty($header)) {
        $header['Content-Type'] = 'application/xml';
    }

    return Response::make($xml->asXML(), $status, $header);
});
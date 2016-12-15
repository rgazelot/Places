<?php

namespace Places\Decoder;

class JsonDecoder
{
    public function decode($data)
    {
        $decodedData = @json_decode($data, true);
        $error = json_last_error();

        if (JSON_ERROR_NONE !== $error) {

            // @see http://php.net/manual/fr/function.json-last-error.php#refsect1-function.json-last-error-returnvalues
            throw new DecodeException(sprintf('An error occured when decoding the data with the error code %d', $error));
        }

        return $decodedData;
    }
}

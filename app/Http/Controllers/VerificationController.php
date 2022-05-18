<?php

namespace App\Http\Controllers;

use Elliptic\EC;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use kornrunner\Keccak;
use Psy\Exception\RuntimeException;

class VerificationController extends Controller
{
    /**
     * @throws /Exception
     */
    public static function verifySignature($message, $signature, $address): bool
    {
        $hash = Keccak::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message), 256);

        $sign = [
            "r" => substr($signature, 2, 64),
            "s" => substr($signature, 66, 64)
        ];

        $recId = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recId !== ($recId & 1)) {
            throw new RuntimeException("Invalid Hex");
        }

        $publicKey = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recId);

        if ((string)Str::of($address)->after('0x')->lower() !==
            substr(Keccak::hash(substr(hex2bin($publicKey->encode('hex')), 1), 256), 24)) {
            throw new RuntimeException("Invalid Signature Hash");
        }

        return true;
    }
}

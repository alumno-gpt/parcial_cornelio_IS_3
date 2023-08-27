<?php 

namespace Classes;

/**
 * La clase Validator proporciona métodos estáticos para realizar validaciones comunes en datos.
 */

class Validator
{

    /**
     * Valida si una dirección de correo electrónico es válida.
     *
     * @param string $email Dirección de correo electrónico a validar.
     * @return bool True si la dirección de correo electrónico es válida, False si no lo es.
     */
    public static function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Valida si una cadena tiene una longitud dentro de un rango específico.
     *
     * @param string $string Cadena a validar.
     * @param int $minLength Longitud mínima permitida.
     * @param int $maxLength Longitud máxima permitida.
     * @return bool True si la cadena cumple con la longitud especificada, False si no lo hace.
     */
    public static function validateStringLength(string $string, int $minLength, int $maxLength)
    {
        if(!empty($string)){
            $length = mb_strlen($string);
            return ($length >= $minLength && $length <= $maxLength);
        }
        return false;
    }

    
    
    /**
     * Verifica si una contraseña ha sido filtrada en una brecha de seguridad conocida.
     * @param string $password La contraseña a verificar.
     * @param bool $verifyHash Indica si se debe verificar el hash en la API de Pwned Passwords.
     * @return bool Retorna true si la contraseña ha sido filtrada, false si es segura o en caso de error.
     */
    public static function isPasswordPwned($password, $verifyHash = false) 
    {
        $haveIBeenPwnedURL = 'https://api.pwnedpasswords.com/range/';
        $hash = strtoupper(sha1($password));
        $prefix = substr($hash, 0, 5);
        $suffix = substr($hash, 5);
        
        try {
            $response = Request::getRequest($haveIBeenPwnedURL . $prefix, $verifyHash);
            
            if ($response) {
                $lines = explode("\n", $response);
                foreach ($lines as $line) {
                    list($hashSuffix, $count) = explode(':', $line);
                    if ($hashSuffix === $suffix) {
                        return true;
                    }
                }
            }
            
            return false;

        } catch (\Exception $e) {
            // Manejar errores de manera adecuada (por ejemplo, loggear el error)
            return false; // Tratar la verificación como fallida en caso de error
        }
    }

    public static function validateNumeric($value)
    {
        return is_numeric($value);
    }

    public static function validateRequired($value)
    {
        return !empty($value);
    }

    public static function validateAlpha($value)
    {
        return preg_match('/^[a-zA-Z\s]+$/', $value);
    }

    public static function validateAlphaNumeric($value)
    {
        return preg_match('/^[a-zA-Z\s0-9]+$/', $value);
    }

    public static function validateUrl($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

    public static function validateDate($value, $format = 'Y-m-d')
    {
        $date = \DateTime::createFromFormat($format, $value);
        return $date && $date->format($format) === $value;
    }

    public static function validateIP($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    public static function validatePassword($value, $minLength = 8, $requireUppercase = true, $requireLowercase = true, $requireDigits = true, $requireSpecialChars = false)
    {
        if (strlen($value) < $minLength) {
            return false;
        }

        if ($requireUppercase && !preg_match('/[A-Z]/', $value)) { // Al menos una letra mayúscula
            return false;
        }

        if ($requireLowercase && !preg_match('/[a-z]/', $value)) { // Al menos una letra minúscula
            return false;
        }

        if ($requireDigits && !preg_match('/\d/', $value)) { // Al menos un número
            return false;
        }

        if ($requireSpecialChars && !preg_match('/[^a-zA-Z\d]/', $value)) { // Al menos un símbolo
            return false;
        }

        return true;
    }

    /**
     * Realiza validaciones en un conjunto de datos utilizando reglas especificadas.
     *
     * @param array $data Conjunto de datos a validar.
     * @param array $rules Reglas de validación en forma de matriz asociativa.
     * @return array Matriz de errores donde las claves son los campos con errores y los valores son matrices de mensajes de error.
     */
    public static function validate($data, $rules)
    {
        $errors = [];

        foreach ($rules as $field => $validators) {
            if (!is_array($validators)) {
                throw new \InvalidArgumentException("Las reglas de validación deben ser una matriz.");
            }
    
            foreach ($validators as $validator) {
                if (!is_array($validator)) {
                    throw new \InvalidArgumentException("Las reglas de validación deben ser matrices de tres elementos.");
                }
    
                if (!is_callable([$validator[0], $validator[1]])) {
                    throw new \InvalidArgumentException("El primer elemento de la regla de validación debe ser una función que pueda ser llamada.");
                }
    
                if (!is_string($validator[2])) {
                    throw new \InvalidArgumentException("El tercer elemento de la regla de validación debe ser una cadena.");
                }
            }
        }

        foreach ($rules as $field => $validators) {
            foreach ($validators as $validator) {
                if (is_callable([$validator[0], $validator[1]])) {
                    $isValid = call_user_func([$validator[0], $validator[1]], $data[$field]);

                    if (!$isValid) {
                        $errors[] = $validator[2];
                    }
                }
            }
        }

        return $errors;
    }
}

/* ejemplo de uso

$data = [
    'email' => 'user@example.com',
    'username' => 'john_doe',
    'age' => 25,
    'CSRF_token' => 'dafsdfasdfj3214kl3j143412343'
];

$rules = [
    'email' => [
        [Validator::class, 'validateEmail', 'Correo electrónico no válido']
    ],
    'username' => [
        [Validator::class, 'validateStringLength', 'El nombre de usuario debe tener entre 4 y 20 caracteres', 4, 20],
        [Validator::class, 'validateAlphaNumeric', 'El nombre de usuario debe contener solo letras y números']
    ],
    'password' => [
        [Validator::class, 'validatePassword', 'La contraseña debe tener al menos una mayúscula, una minúscula, un número, un símbolo y una longitud de 8 caracteres'],
        [Validator::class, 'isPasswordPwned', 'Esta contraseña ha sido filtrada en múltiples ocaciones, favor utilizar otra']
    ],
    'age' => [
        [Validator::class, 'validateNumeric', 'La edad debe ser un número válido']
    ],
    'website' => [
        [Validator::class, 'validateUrl', 'La URL del sitio web no es válida']
    ],
    'birth_date' => [
        [Validator::class, 'validateDate', 'La fecha de nacimiento no es válida', 'Y-m-d']
    ],
    'ip_address' => [
        [Validator::class, 'validateIP', 'La dirección IP no es válida']
    ],
    'csrf_token' => [
        [Validator::class, 'validateRequired', 'El token CSRF es requerido'],
        [Csrf::class, 'verifyToken', 'El token CSRF es invalido']
    ]
];

$errors = Validator::validate($data, $rules);

if (empty($errors)) {
    // Los datos son válidos
} else {
    // Los datos no son válidos, mostrar errores
    print_r($errors);
}*/

?>
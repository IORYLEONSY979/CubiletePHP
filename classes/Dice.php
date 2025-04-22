<?php
class Dice {
    private $semilla1;
    private $semilla2;
    
    public function __construct() {
        $this->semilla1 = rand(1000, 9999);
        $this->semilla2 = rand(1000, 9999);
    }
    
    public function roll() {
        $valor_dado = 0;
        $intentos = 0;
        
        while ($valor_dado == 0 && $intentos < 100) {
            $intentos++;
            $resultado = $this->semilla1 * $this->semilla2;
            $resultado_str = ($resultado % 2 != 0) ? '0'.$resultado : $resultado;
            $resultado_str = str_pad($resultado_str, 8, '0', STR_PAD_LEFT);
            if (strlen($resultado_str) > 8) $resultado_str = substr($resultado_str, -8);
            $nuevo_numero = intval(substr($resultado_str, 2, 4));
            
            if ($nuevo_numero == 0) {
                $this->semilla1 = $this->semilla2;
                $this->semilla2 = rand(1000, 9999);
                continue;
            }
            
            $valor_dado = ($nuevo_numero % 6) + 1;
            $this->semilla1 = $this->semilla2;
            $this->semilla2 = $nuevo_numero;
        }
        
        return $valor_dado != 0 ? $valor_dado : rand(1, 6);
    }
    
    public function rollMultiple($count = 5) {
        $rolls = [];
        for ($i = 0; $i < $count; $i++) {
            $rolls[] = $this->roll();
        }
        return $rolls;
    }
}
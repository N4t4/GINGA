<?php

  class InArquivos
  {
    
    public function InserirArquivo($arq, $caminho)
    {
      $erro = 0;  
      // Verifica se o arquivo � valido 
      if(!preg_match("/^(application|image)\/(pjpeg|jpeg|png|gif|pdf|bmp)$/", $arq["type"]))
      {
        //"Este tipo de arquivo n�o � suportado!"
        $erro = 1;
      }
      
      
      $tamanho =  5242880;
      //veirifica se excedeu o tamanho maximo em bytes
      if($arq["size"] > $tamanho) 
      {
        //"Este arquivo � muito grande ele deve ter no m�ximo "$tamanho" bytes";
        $erro = 2;
      }
      
      // Se n�o houver nenhum erro
      if ($erro == 0) 
      {   
        // Pega extens�o da imagem
        preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $arq["name"], $ext);
   
            // Gera um nome �nico
            $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
   
            // Caminho de onde ficar� o arquivo
            $caminho_imagem = $caminho . $nome_imagem;
   
        // Faz o upload para seu respectivo caminho
        move_uploaded_file($arq["tmp_name"], $caminho_imagem);      
        
        return $caminho_imagem;
      } 
    }   
    
    public function DeletarArquivo($nome_arq)
    {
      unlink($nome_arq);
    }
    
  }
  
?>

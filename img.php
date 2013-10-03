<?php
/**
 * Cria um thumb de uma imagem jpg e retorna na tela ou salva em disco
 * 
 * @param string $imgSrc - Path fisico onde vão ser criados os novos diretórios
 * @param int $thumbnail_width  - Nome dos diretórios que serão criados separados por "/" EX: (produtos/categoria/informatica)
 * @param int $thumbnail_height  - Nome dos diretórios que serão criados separados por "/" EX: (produtos/categoria/informatica)
 * @example CropThumb('images/Penguins.jpg',100,100);
 * @return void se for criar a imgem em disco e image/jpeg se for mostrar na tela
 */
function CropThumb($imgSrc,$thumbnail_width='100',$thumbnail_height='100') { 
    
    //Cria uma novo imagem com base na imagem passada no $imgSrc
    $myImage = imagecreatefromjpeg($imgSrc);
    
    //Pega as dimensões da imagem
    list($width_orig, $height_orig) = getimagesize($imgSrc);

    //Pega o "ratio" para sempre redimensionar na proporção
    $ratio_orig = $width_orig/$height_orig;
   
    //Faz o calculo de proporção pela largura ou altura
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
   
    //Pegamos o ponto central da imagem
    $x_mid = $new_width/2;  
    $y_mid = $new_height/2;
   
    //Criamos uma base de imagem na nova dimensão
    $process = imagecreatetruecolor(round($new_width), round($new_height));
   
    //Geramos a imagem
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    
    //Geramos um thumb redimensionado e cropado
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);
    
    //limpamos a memoria usada
    imagedestroy($process);
    imagedestroy($myImage);
    
    //retorna o thumb
    return $thumb;
}

//Chamamos a função de criar o thumb
$newThumb = CropThumb($_REQUEST['src'],$_REQUEST['w'],$_REQUEST['h']);

//E mostramos a imagem ou salvamos em disco
if(isset($_REQUEST['save'])){
    imagejpeg($newThumb,$_REQUEST['save'],100);
    chmod($_REQUEST['save'],0777);
}else{
    header('Content-type: image/jpeg');
    imagejpeg($newThumb,null,100);
}
exit();

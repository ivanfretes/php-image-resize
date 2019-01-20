## php-resize-migrate

Redimensionador de Imagenes con GD y migrar los PATH a SQL


### Opciones de redimensión de la imagen

    - $image->setDimensions($newWidth, $newHeight); - nuevo ancho y nuevo algo
    - $image->setWithHeight($newHeight); - ratio por el alto
    - $image->setWithWidth($newWidth);
    - setWithPercent($percent)
    

### Opciones referente al nombre de la imagen

    1. Si no se asigna nombre, guarda por defecto como image-resize.[x]
    2. $image->setNewFileName($newName); - Nuevo nombre de la imagen, no especificar formato
	3. $image->setNewPath($newPath); - Nuevo destino de la imagen
    4. $image->notRenameFile(); conservar el nombre original
 
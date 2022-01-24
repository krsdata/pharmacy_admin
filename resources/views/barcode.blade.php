<head>
    <title>Kundan Roy</title>
</head>
<body>
  
   
@php
    $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
@endphp
  
 {!! $generator->getBarcode('hello how are you', $generator::TYPE_CODE_39) !!}
  
<br>
IMAGE Formate 
</br>  
@php
    $generatorPNG = new \Picqer\Barcode\BarcodeGeneratorPNG();
@endphp 
  
<img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode('I love you', $generatorPNG::TYPE_CODE_128)) }}"> 
</body>
</html>
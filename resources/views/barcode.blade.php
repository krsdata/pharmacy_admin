<head>
    <title>How to Generate Bar Code in Laravel? - ItSolutionStuff.com</title>
</head>
<body>
  
   
@php
    $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
@endphp
  
{!! $generator->getBarcode('Love you always', $generator::TYPE_CODE_128) !!}
  

</body>
</html>
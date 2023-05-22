<form method="GET" action="/search">
  {{csrf_field()}}
  <input id="code" type="text" value="" name="code">
  <input type="submit" class="btn btn-primary" value="送信">
</form>

@isset($rakutenItem)
  <a href="{{$rakutenItem->getUrl()}}">
    <img src="{{$rakutenItem->getImageUrl()}}"alt="商品画像">
      {{$rakutenItem->getName()}}
  </a>
  <input type="submit" value="登録">
@endisset

<script>
    <script type="text/javascript" src="https://serratus.github.io/quaggaJS/examples/js/quagga.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    // const fetchProducts = async (code) => {
    //     await axios.get("/search", {
    //         params:{ "code" :code }
    //     })
    //     .then(res => console.log(res))
    //     .catch(err => console.error(err));
    // }

    Quagga.init({
        inputStream: { type : 'LiveStream' },
        decoder: {
            readers: [{
                format: 'ean_reader',
                config: {},
                multiple: false,
            }]
        }
    }, (err) => {
        if(!err) {
            Quagga.start();
        }
    });

    Quagga.onDetected((result) => {
        const code = result.codeResult.code;
        // fetchProducts(code);
        document.getElementById("code").value= code;
    });


</script>
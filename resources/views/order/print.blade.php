<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
      <div class="row gy-3 mb-3">
        <div class="col-6">
          <h2 class="text-uppercase text-endx m-0">Invoice</h2>
        </div>
        <div class="col-6">
          <a class="d-block text-end" href="#!">
            <img src="{{ asset('images/icon.jpg') }}" class="img-fluid" alt="BootstrapBrain Logo" width="135" height="44">
          </a>
        </div>
        <div class="col-12">
          <h4>Dari</h4>
          <address>
            <strong>Liza Cake</strong><br>
            875 N Coast Hwybr<br>
            Laguna Beach, California, 92651<br>
            United States<br>
            Phone: 08197922146<br>
            Email: info@foodie.com.my
          </address>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12 col-sm-6 col-md-8">
          <h4>Pemesan</h4>
          <address>
            <strong>{{ auth()->user()->name }}</strong><br>
            Jenis Pesanan: {{ ucfirst($order['type']) }}<br>
            @if(!$order['deliveryAddress'])
              {{ $order['deliveryAddress'] }}<br>
            @endif
            Phone: -<br>
            Email: {{ auth()->user()->email }}
          </address>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <h4 class="row">
            <span class="col-6">Invoice </span>
            <span class="col-6 text-sm-end">#ORDER-{{ $order['id'] }}</span>
          </h4>
          <div class="row">
            <span class="col-6">Tanggal Pesanan</span>
            <span class="col-6 text-sm-end">{{ \Carbon\Carbon::parse($order['date'])->translatedFormat('j F Y') }}</span>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th scope="col" class="text-uppercase">Nama Barang</th>
                <th scope="col" class="text-uppercase">Jumlah</th>
                <th scope="col" class="text-uppercase text-end">Harga Satuan</th>
                <th scope="col" class="text-uppercase text-end">Harga Total</th>
              </tr>
              </thead>
              <tbody class="table-group-divider">
              @foreach($order['food'] ?? [] as $item)
                <tr>
                  <td>{{ $item['name'] }}</td>
                  <th scope="row">{{ $item['pivot']['quantity'] }}</th>
                  <td class="text-end">{{ number_format($item['pivot']['harga_item'], 0, ',', ',') }}</td>
                  <td class="text-end">{{ number_format($item['pivot']['total_item'], 0, ',', ',') }}</td>
                </tr>
              @endforeach
              <tr>
                <th scope="row" colspan="3" class="text-uppercase text-end">Total Seluruh</th>
                <th scope="row" class="text-uppercase text-end">{{ number_format($order['total'], 0, ',', ',') }}</th>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.onload = function() {
    setTimeout(function() {
      window.print();
    }, 500);
  };

  window.onafterprint = function() {
    setTimeout(function() {
      window.location.href = '/order';
    }, 100);
  };
</script>

</body>
</html>

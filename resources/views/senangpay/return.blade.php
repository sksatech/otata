<html>
<body onload="document.order.submit()">
    <body>
    <form name="order" method="post" action="{{ route('senangpay.update.paid') }}">
        @csrf
        <input type="hidden" name="order_id" value="<?php echo $_GET['order_id'] ?>">
        <input type="hidden" name="transaction_id" value="<?php echo $_GET['transaction_id'] ?>">
        <input type="hidden" name="status" value="<?php echo $_GET['status_id'] ?>">
    </form>
</body>
</html>
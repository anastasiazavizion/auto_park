@component('mail::message')
    New Order has been created
@component('mail::table')
<table>
    <thead>
    <tr>
        <th>Order #</th>
        <th>Total</th>
        <th>Start</th>
        <th>Finish</th>
        <th>User name</th>
        <th>Image</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$order->id}}</td>
        <td>${{$order->total}}</td>
        <td>{{$order->start}}</td>
        <td>{{$order->finish}}</td>
        <td>{{$order->user->name}}</td>
        <td><img src="{{$order->car->image}}" style="width: 100px;" alt="{{$order->car->model}}"></td>
    </tr>
    </tbody>
</table>
@endcomponent
@endcomponent

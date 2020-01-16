<tr>
  <th scope="row">{{ $order->id }}</th>
  <td>{{ $order->user->name }}</td>
  <td>{{ $order->user->email }}</td>
  <td>&euro; {{ centsToEuro($order->getTotal()) }}</td>
  <td>{{ formatTimeForDisplay($order->created_at) }}</td>
  <td>
    <ul class="ml-0 pl-0">
      @foreach($order->orderHasProducts as $ohp) 
      <li>{{ $ohp->product->title }}</li>
      @endforeach
    </ul>
  </td>
  <td>
    <button onclick="document.getElementById('fulfill-{{ $order->id }}').submit();" class="btn btn-primary">Vervul/Onvervul</button>
    <form id="fulfill-{{ $order->id }}" action="{{ route('orders.update', ['order' => $order->id]) }}" method="post" class="d-none">
      @csrf
      @method('PATCH')
      <input type="text" name="fulfilled" value="toggle">
    </form>
  </td>
  <td>
    <a href="{{ route('orders.show', ['order' => $order->id]) }}" class="btn btn-info">Bekijken</a>
  </td>
  <td>
    <button onclick="document.getElementById('delete-{{ $order->id }}').submit();" class="btn btn-danger">Verwijderen</button>
    <form id="delete-{{ $order->id }}" action="{{ route('orders.destroy', ['order' => $order->id]) }}" method="post" class="d-none">
      @csrf
      @method('DELETE')
    </form>
  </td>
</tr>
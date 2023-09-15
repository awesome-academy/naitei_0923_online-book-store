<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        @if (count($cartItems) > 0)
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-lg font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Ảnh
                        </th>
                        <th class="px-6 py-3 text-left text-lg font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Sản phẩm
                        </th>
                        <th class="px-6 py-3 text-left text-lg font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Số Lượng
                        </th>
                        <th class="px-6 py-3 text-left text-lg font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Giá
                        </th>
                        <th class="hidden px-6 py-3 text-left text-lg font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Tổng
                        </th>

                        <th class="relative px-6 py-3">
                            <span class="sr-only">Xóa</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-slate-600 divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($cartItems as $cartItem)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex justify-center">
                                <img src="{{ asset('default.jpg.webp') }}" class="w-20 h-20 object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-gray-500 dark:text-gray-100">
                            <div class="flex justify-center">
                                {{ $cartItem->book->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500 dark:text-gray-400">
                            <div class="flex items-center justify-center">
                                <button class="px-2 py-1 bg-blue-500 text-white rounded-l hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-500" onclick="decreaseQuantity({{ $cartItem->id }})">-</button>
                                <span id="quantity-{{ $cartItem->id }}" data-book-price="{{ $cartItem->book->price }}" class="px-4">{{ $cartItem->quantity }}</span>
                                <button class="px-2 py-1 bg-blue-500 text-white rounded-r hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-500" onclick="increaseQuantity({{ $cartItem->id }})">+</button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500 dark:text-gray-400">
                            <div class="flex justify-center">
                                ${{ $cartItem->book->price }}
                            </div>
                        </td>
                        <td id="total-{{ $cartItem->id }}" class="hidden px-6 py-4 whitespace-nowrap text-base text-gray-500 dark:text-gray-400">
                            ${{ $cartItem->quantity * $cartItem->book->price }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-base font-medium">
                            <a href="/remove-from-cart/{{ $cartItem->id }}" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600">Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 bg-gray-100 dark:bg-gray-900">
                <p id="cart-total" class="text-xl text-gray-500 dark:text-gray-100">Tổng tiền: </p>
            </div>
            <div class="px-6 py-4 text-right">
                <a href="/checkout" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-500">
                    Thanh toán
                </a>
            </div>
        </div>
        @else
        <p class="text-xl text-gray-500 dark:text-gray-100 mt-4">Giỏ hàng trống.</p>
        @endif
    </div>

    <script>
        function updateTotal(cartItemId, quantity) {
            var priceElement = document.querySelector(`#quantity-${cartItemId}`);
            var totalElement = document.querySelector(`#total-${cartItemId}`);
            var price = parseFloat(priceElement.getAttribute('data-book-price'));
            totalElement.textContent = '$' + (price * quantity).toFixed(2);
            updateCartTotal();
        }

        function increaseQuantity(cartItemId) {
            var quantityElement = document.getElementById('quantity-' + cartItemId);
            var currentQuantity = parseInt(quantityElement.innerText);
            quantityElement.innerText = currentQuantity + 1;
            updateTotal(cartItemId, currentQuantity + 1);
        }

        function decreaseQuantity(cartItemId) {
            var quantityElement = document.getElementById('quantity-' + cartItemId);
            var currentQuantity = parseInt(quantityElement.innerText);
            if (currentQuantity > 0) {
                quantityElement.innerText = currentQuantity - 1;
                updateTotal(cartItemId, currentQuantity - 1);
            }
        }

        function updateCartTotal() {
            var totalElements = document.querySelectorAll('[id^="total-"]');
            var cartTotal = 0;
            totalElements.forEach(function(element) {
                var text = element.textContent.replace('$', '');
                cartTotal += parseFloat(text);
            });
            document.getElementById('cart-total').textContent = 'Tổng tiền: $' + cartTotal.toFixed(2);
        }
    </script>
</x-app-layout>

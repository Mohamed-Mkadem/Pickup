@extends('layouts.client-store')

@push('title')
    <title>{{ $store->name }} | Cart</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @if ($store->status == 'unpublished')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/404_error.svg') }}" alt="">
                <p class="info-message">This store's subscription has expired, and it is no
                    longer available for browsing or making purchases. It will remain inaccessible until the
                    store owner purchases a new subscription. We apologize for any inconvenience caused. In the
                    meantime, feel free to check out our other active stores for your shopping needs.</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @elseif($store->status == 'maintenance')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/maintenance.svg') }}" alt="">
                <p class="info-message">This store is currently undergoing maintenance to improve your shopping
                    experience. The store owner is working diligently
                    to complete the necessary fixes and updates. Once the maintenance is finished, the store
                    will be published again. Thank you for your patience and understanding</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @else
            @include('components.errors-alert')
            @include('components.session-errors-alert')
            @include('components.success-alert')
            @include('components.Stores.client-store-header', ['store' => $store])
            <!-- Start Store Content -->
            <div class="store-content mt-2">
                @if ($cartInfo)
                    <div class="results">

                        <h2 class="t-left mb-0">Cart : <span id="totalProducts"></span></h2>

                        <div class="cart-holder main-holder">
                            <form action="{{ route('client.cart.update', $cartInfo->id) }}" method="post" id="cartForm">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="cart" id="cartInput" value='{{ $cart }}'>

                                <input type="hidden" name="cartAmount" id="cartAmount"
                                    value="{{ number_format($cartInfo->amount, 3, ',') }}">
                                <input type="hidden" name="cartItemsCount" id="cartItemsCount"
                                    value="{{ $cartInfo->products()->count() }}">
                                <input type="hidden" name="storeID" id="storeID">
                                <div class="table-responsive client-cart-table ">
                                    <table>

                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Price <span>(DT)</span></th>
                                                <th>Quantity</th>
                                                <th>Total <span>(DT)</span></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-tbody"></tbody>

                                    </table>


                                </div>
                                <div class="form-control d-flex col a-end ">
                                    <p class="cart-total fw-bold mt-1">Total : <span
                                            id="total-span">{{ number_format($cartInfo->amount, 3, ',') }}</span>
                                        (DT)
                                    </p>
                                    <p class="error-message" id="error-message">Something went Wrong!</p>
                                </div>
                            </form>
                            <div class="buttons d-flex j-start gap-1 wrap mt-1 @if ($cartInfo->amount == 0) d-none @endif "
                                id="btns-holder">
                                <button class="resetBtn" name="action" value="empty">Empty Cart</button>

                                <div class="modal-holder ">
                                    <form action="{{ route('client.cart.empty', $cartInfo->id) }}" method="post"
                                        class="modal t-center confirm-form">
                                        @csrf
                                        @method('PATCH')
                                        <i class=" fa-light fa-trash"></i>
                                        <p>Are You Sure You Want To Empty The Cart ?</p>
                                        <div class="buttons d-flex j-center a-center">
                                            <button class="cancelBtn">Cancel</button>
                                            <button class="confirmBtn">Yes</button>
                                        </div>
                                    </form>
                                </div>

                                <button type="submit" id="updateBtn" name="action" value="updateCart"
                                    class="updateBtn">Update
                                    Cart</button>
                                <a href="{{ route('client.store.checkout', $store->username) }}" class="submitBtn">Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="not-found-holder show">
                        <div class="wrapper">
                            <i class="fa-light fa-circle-info"></i>
                            <p class="mb-1">No Cart Found! Start Shopping To Create A Cart On This Store</p>
                            <a href="{{ route('client.store.products', $store->username) }}"
                                class="activate-button p-1 ">Start Shopping </a>
                        </div>
                    </div>
                @endif

            </div>
            <!-- End Store Content -->
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        const username = "{{ $store->username }}"
        const cartInput = document.getElementById('cartInput')
        const cartAmount = document.getElementById('cartAmount')
        const cartItemsCount = document.getElementById('cartItemsCount')
        const storeID = document.getElementById('storeID')
        const totalProducts = document.getElementById('totalProducts')
        if (cartInput) {
            let oldCart = JSON.parse(cartInput.value)

            const tbody = document.getElementById('cart-tbody')
            const totalSpan = document.getElementById('total-span')
            totalSpan.textContent = cartAmount.value
            totalProducts.textContent = cartItemsCount.value
            let cart = [...oldCart];
            updateCart()

            function updateCart() {
                tbody.innerHTML = ''
                cart.forEach((product) => {
                    const tr = document.createElement('tr');
                    tr.setAttribute('data-productid', product.product_id)
                    // Create the <td> elements and set their content and attributes
                    const deleteCell = document.createElement('td');
                    const deleteButton = document.createElement('button');
                    deleteButton.classList.add('delete-button');
                    deleteButton.innerHTML = '<i class="fa-light fa-trash"></i>';
                    deleteCell.appendChild(deleteButton);

                    const imageCell = document.createElement('td');
                    const image = document.createElement('img');
                    image.src = product.image;
                    image.alt = "";
                    imageCell.appendChild(image);

                    const productNameCell = document.createElement('td');
                    const productNameLink = document.createElement('a');
                    productNameLink.href = `product/${product.product_id}`;
                    productNameLink.textContent = product.name;
                    productNameCell.appendChild(productNameLink);

                    const productPriceCell = document.createElement('td');
                    productPriceCell.textContent = parseFloat(product.price).toFixed(3);

                    const quantityCell = document.createElement('td');
                    const quantityHolder = document.createElement('div');
                    quantityHolder.classList.add('quantity-holder');

                    const minusButton = document.createElement('button');
                    minusButton.classList.add('minusBtn');
                    minusButton.textContent = '-';
                    quantityHolder.appendChild(minusButton);

                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'number';
                    quantityInput.classList.add('form-element', 'quantityInput');
                    quantityInput.value = product.quantity;
                    quantityHolder.appendChild(quantityInput);

                    const plusButton = document.createElement('button');
                    plusButton.classList.add('plusBtn');
                    plusButton.textContent = '+';
                    quantityHolder.appendChild(plusButton);

                    quantityCell.appendChild(quantityHolder);

                    const totalCell = document.createElement('td');
                    totalCell.classList.add('totalTD');
                    totalCell.textContent = (product.price * product.quantity).toFixed(3);

                    // Append the <td> elements to the <tr>
                    tr.appendChild(deleteCell);
                    tr.appendChild(imageCell);
                    tr.appendChild(productNameCell);
                    tr.appendChild(productPriceCell);
                    tr.appendChild(quantityCell);
                    tr.appendChild(totalCell);

                    // Append the <tr> to the tbody
                    tbody.appendChild(tr);
                });



            }

            function increaseProductQuantity(productId, quantity) {
                const targetProduct = cart.find((product) => product.product_id == productId);
                if (targetProduct) {
                    targetProduct.quantity += quantity
                }
            }

            function decreaseProductQuantity(productId, quantity) {
                const targetProduct = cart.find(product => product.product_id == productId);
                // console.log("file: seller_sale_add.html:612 ~ decreaseProductQuantity ~ targetProduct:", targetProduct)
                if (targetProduct) {
                    targetProduct.quantity -= quantity
                }
            }

            function setProductQuantity(productId, quantity) {
                const targetProduct = cart.find((product) => product.product_id == productId);
                console.log(targetProduct);
                if (targetProduct) {
                    targetProduct.quantity = quantity
                }
            }
            tbody.addEventListener('click', (event) => {
                if (event.target.classList.contains('minusBtn')) {
                    const quantityInput = event.target.nextElementSibling;
                    if (quantityInput.value != 1) {
                        quantityInput.value = parseInt(quantityInput.value) - 1;
                        calcProductTotal(quantityInput);

                        decreaseProductQuantity(quantityInput.closest('tr').dataset.productid, 1)
                        setInputsValues()

                    }
                }
            });


            tbody.addEventListener('click', (event) => {
                if (event.target.classList.contains('plusBtn')) {
                    const quantityInput = event.target.previousElementSibling;
                    quantityInput.value = parseInt(quantityInput.value) + 1;


                    calcProductTotal(quantityInput);
                    increaseProductQuantity(quantityInput.closest('tr').dataset.productid, 1)
                    setInputsValues()

                }
            });

            function calcProductTotal(quantityInput) {
                const price = parseFloat(quantityInput.parentElement.parentElement.previousElementSibling.textContent)
                const totalTD = quantityInput.parentElement.parentElement.nextElementSibling
                const totalvalue = (price * parseInt(quantityInput.value)).toFixed(3)
                totalTD.textContent = totalvalue
                calcTotal()

            }

            const quantityInputs = Array.from(document.querySelectorAll('.quantityInput'))
            tbody.addEventListener('input', (e) => {
                if (e.target.classList.contains('quantityInput')) {
                    if (e.target.value != 0) {
                        calcProductTotal(e.target)

                        setProductQuantity(e.target.closest('tr').dataset.productid, parseInt(e.target.value))


                        setInputsValues()
                    } else {
                        e.target.value = 1
                        setProductQuantity(e.target.closest('tr').dataset.productid, parseInt(e.target.value))
                        setInputsValues()
                    }
                }
            })

            function calcTotal() {
                let total = 0
                let totalTDs = document.querySelectorAll('.totalTD')
                for (let i = 0; i < totalTDs.length; i++) {
                    total += parseFloat(totalTDs[i].textContent)

                }
                totalSpan.textContent = total.toFixed(3)

            }

            tbody.addEventListener('click', (event) => {
                if (event.target.classList.contains('delete-button')) {
                    const row = event.target.closest('tr');

                    const productId = row.dataset.productid;

                    // Remove the product from the cart
                    removeProduct(productId);

                    // Remove the row from the table
                    row.remove();


                    // Recalculate the total
                    calcTotal();
                    setInputsValues()
                }
            });

            function removeProduct(productId) {
                // Remove the product with the given productId from the cart
                const index = cart.findIndex((product) => product.product_id == productId);
                if (index !== -1) {
                    cart.splice(index, 1);

                    updateDataCount(cart.length)
                }

            }

            function updateDataCount(count) {
                totalProducts.textContent = count
            }
            const modalBtn = document.querySelector('.resetBtn')
            const cancelBtn = document.querySelector('.cancelBtn')
            const modalHolder = document.querySelector('.modal-holder')
            cancelBtn.addEventListener('click', () => {
                modalHolder.classList.remove('show')
                document.body.classList.remove('no-scroll')

            })
            modalHolder.addEventListener('click', (e) => {
                if (e.target.classList.contains('modal-holder')) {
                    modalHolder.classList.remove('show')
                    document.body.classList.remove('no-scroll')
                }
            })
            modalBtn.addEventListener('click', () => {

                modalHolder.classList.add('show')
                document.body.classList.add('no-scroll')
            })



            const updateBtn = document.getElementById('updateBtn')
            const cartErrorMessage = document.getElementById('error-message')
            updateBtn.addEventListener('click', () => {
                let tbody = document.getElementById('cart-tbody')
                if (tbody.innerHTML === '') {
                    cartErrorMessage.textContent = 'At least One product must be added!'
                    cartErrorMessage.classList.add('show')

                } else {
                    cartErrorMessage.textContent = ''
                    cartErrorMessage.classList.remove('show')
                    cartForm.submit()

                }

            })

            function setInputsValues() {
                cartInput.value = JSON.stringify(cart)
                // console.log("file: seller_sale_add.html:940 ~ setInputsValues ~ cartInput:", cartInput)
                cartItemsCount.value = cart.length
                // console.log("file: seller_sale_add.html:941 ~ setInputsValues ~ cartItemsCount:", cartItemsCount)
                let cartAmountValue = document.getElementById('total-span').textContent
                cartAmount.value = parseFloat(cartAmountValue).toFixed(3)
                // console.log("file: seller_sale_add.html:943 ~ setInputsValues ~ cartAmount:", cartAmount)
                buttonsChecker()
            }

            function buttonsChecker() {
                let buttonsHolder = document.getElementById('btns-holder')
                let tbody = document.getElementById('cart-tbody')
                if (tbody.innerHTML === '') {
                    buttonsHolder.classList.add('d-none')
                } else {
                    buttonsHolder.classList.remove('d-none')
                    cartErrorMessage.textContent = ''
                    cartErrorMessage.classList.remove('show')
                }
            }

            const cartForm = document.getElementById('cartForm')
            cartForm.addEventListener('submit', e => {
                e.preventDefault()
            })
        }
    </script>
@endpush

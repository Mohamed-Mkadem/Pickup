<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup | New Sale </title>
    <link rel="shortcut icon" href="{{ asset('dist/Assets/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('dist/CSS/utilities.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/CSS/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/CSS/app_dark.css') }}">

    <!-- <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@44659d9/css/all.min.css" rel="stylesheet"
        type="text/css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" type="text/css">
</head>


<body>
    <!-- <div class="preloader" id="preloader">
        <div class="loader-wrapper">
            <a href="index.html" class="logo d-block visible"><i class="fa-light fa-bag-shopping"></i>
                <span>Pickup</span> </a>
            <div class="circles">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
                <div class="circle circle-4"></div>
                <div class="circle circle-4"></div>
            </div>
        </div>
    </div> -->
    <div id="overlay" class="overlay"></div>
    <div class="main-wrapper">
        <div class="sale-wrapper">
            <div class="cart-toggle-holder">
                <button id="cartToggle" data-count="19">
                    <i class="fa-light fa-bag-shopping"></i>
                </button>
            </div>
            <!-- Start Cart Holder -->
            <div class="sale-cart " id="sale-cart">
                <div class="cart-holder">
                    <form action="{{ route('seller.sales.store') }}" id="cart-form" method="post">
                        @csrf
                        <div class="form-control">
                            <input type="text" name="customer_name" placeholder="Customer Name (Optional)"
                                class="form-element">
                        </div>
                        <input type="hidden" name="cart" id="cartInput" value="{{ old('cart', '') }}">
                        {{-- <input type="hidden" name="cartAmount" id="cartAmount">
                        <input type="hidden" name="cartItemsCount" id="cartItemsCount">
                        <input type="hidden" name="storeID" id="storeID"> --}}
                        <div class="table-responsive sale-cart-table ">
                            <table>

                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price <span>(DT)</span></th>
                                        <th>Qty</th>
                                        <th>Total <span>(DT)</span></th>
                                    </tr>
                                </thead>
                                <tbody id="cart-tbody"></tbody>
                            </table>

                        </div>
                        <div class="form-control d-flex col a-end ">
                            <p class="cart-total fw-bold mt-1">Total : <span id="total-span">0.000</span> (DT)</p>
                            <p class="error-message" id="error-message">Something went Wrong!</p>
                            @include('components.errors-alert')
                            @include('components.session-errors-alert')
                            @include('components.success-alert')
                        </div>
                        <div class="buttons d-flex j-end gap-1 wrap mt-1 d-none" id="btns-holder">
                            <button class="resetBtn">Reset</button>

                            <div class="modal-holder ">
                                <div class="modal t-center confirm-form">
                                    <i class=" fa-light fa-trash"></i>
                                    <p>Are You Sure You Want To Reset This Sale ?</p>
                                    <div class="buttons d-flex j-center a-center ">
                                        <button class="cancelBtn">Cancel</button>
                                        <button class="confirmBtn" id="resetBtn">Yes</button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="submitBtn" class="submitBtn">Add Sale</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Cart Holder -->
            <!-- Start Sale Products -->
            <div class="sale-products">
                <form action="" method="get" id="products-form">




                    <div class="sale-products-holder">
                        <div class="d-flex  categories-wrapper">
                            <!-- Start Category -->
                            <div class="relative sale-category">
                                <img src="{{ asset('dist/Assets/store.svg') }}" alt="">
                                <h4 title="All"> All</h4>
                                <input checked type="radio" class="absolute" name="category" value="all">
                            </div>
                            <!-- End Category -->
                            @foreach ($categories as $category)
                                <!-- Start Category -->
                                <div class="relative sale-category">
                                    <img src="{{ $category->icon }}">
                                    {{-- <img src="{{ asset('storage/' . $category->icon) }}"> --}}
                                    <h4 title="{{ $category->name }}"> {{ $category->name }}</h4>
                                    <input type="radio" class="absolute" name="category"
                                        value="{{ 'cat_' . $category->id }}">
                                </div>
                                <!-- End Category -->
                            @endforeach
                        </div>

                        <div class="container fluid products-holder">
                            <div class="form-control m-block-1 holder radius-10 p-0-5">
                                <input type="text" name="product-name" placeholder="Type A Product Name"
                                    class="form-element" id="searchInput">
                            </div>
                            @if ($products->count() > 0)
                                <div class="results">
                                    <div class="results-holder products-grid" id="productsContainer">
                                        @foreach ($products as $product)
                                            <!-- Start Product  -->
                                            <div
                                                class="product holder radius-10 all {{ 'cat_' . $product->category_id }}">
                                                <p class="product-quantity-holder mb-1">Quantity: <span
                                                        class="quantity-value"
                                                        data-id="{{ $product->id }}">{{ $product->quantity }}</span>
                                                </p>
                                                <div class="img-holder">
                                                    <img loading="lazy"
                                                        src=" {{ asset('storage/' . $product->image) }} "
                                                        class=" radius-10" alt="">
                                                </div>
                                                <div class="info-holder">
                                                    <h3 class="product-name">{{ $product->name }}</h3>
                                                    <p class="product-price">
                                                        <span>{{ number_format($product->price, 3, ',') }}</span>
                                                        <small>DT</small>
                                                    </p>
                                                    <p class="product-brand">{{ $product->brand->name }}</p>
                                                </div>
                                                <div class="actions d-flex j-sp-between a-center gap-0-5 wrap">
                                                    <button class="submitBtn addToCartBtn w-100"
                                                        data-id="{{ $product->id }}">
                                                        <i class="fa-light fa-cart-shopping"></i> ADD
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- End Product  -->
                                        @endforeach


                                    </div>
                                </div>
                            @else
                                <!-- Start Not found -->
                                <div class="not-found-holder show small">
                                    <div class="wrapper">
                                        <i class="fa-light fa-circle-info"></i>
                                        <p>There Is No Results Found</p>
                                    </div>
                                </div>
                                <!-- End Not found -->
                            @endif
                        </div>
                    </div>


                </form>
            </div>
            <!-- End Sale Products -->

        </div>
        <audio id="sound-effect" style="height:0px; width: 0px; position: absolute; left: -2500px;"
            src="{{ asset('dist/Assets/sound.mp3') }}"></audio>
    </div>
    <script>
        const baseUrl = "{{ asset('') }}";
    </script>
    <script>
        const cartInput = document.getElementById('cartInput')
        const tbody = document.getElementById('cart-tbody')
        const totalSpan = document.getElementById('total-span')

        function calcTotal() {
            let total = 0
            let totalTDs = document.querySelectorAll('.totalTD')
            for (let i = 0; i < totalTDs.length; i++) {
                total += parseFloat(totalTDs[i].textContent)
                // console.log(totalTDs[i].textContent);
            }
            totalSpan.textContent = total.toFixed(3)

        }
        const cartToggleBtn = document.getElementById('cartToggle')
        const saleCart = document.getElementById('sale-cart')

        let cart = [];
        if (cartInput.value) {
            let oldCart = JSON.parse(cartInput.value)
            cart = [...oldCart]
            updateCart()
            updateDataCount(cart.length)
            calcTotal()
        }

        // Get the audio element
        const soundEffect = document.getElementById('sound-effect');

        function increaseProductQuantity(productId, quantity) {
            const targetProduct = cart.find((product) => product.id === productId);
            if (targetProduct) {
                targetProduct.quantity += quantity
            }
        }

        function decreaseProductQuantity(productId, quantity) {
            const targetProduct = cart.find(product => product.id === productId);

            if (targetProduct) {
                targetProduct.quantity -= quantity
            }
        }

        function setProductQuantity(productId, quantity) {
            const targetProduct = cart.find((product) => product.id === productId);
            // console.log(targetProduct);
            if (targetProduct) {
                targetProduct.quantity = quantity
            }
        }


        function removeAlerts() {
            const alerts = Array.from(document.querySelectorAll('.alert'))
            alerts.forEach((alert) => {
                alert.classList.add('d-none')
            })
        }





        cartToggleBtn.addEventListener('click', () => {
            saleCart.classList.add('modal')
            document.body.classList.add('no-scroll')
        })

        function updateDataCount(count) {
            cartToggleBtn.setAttribute('data-count', count)
        }
        updateDataCount(cart.length)
        const productsForm = document.getElementById('products-form')

        productsForm.addEventListener('submit', (e) => {
            e.preventDefault()
        })

        const addToCartBtns = Array.from(document.querySelectorAll('.addToCartBtn'))
        addToCartBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Get the product details
                const productId = btn.dataset.id
                const productInfo = btn.parentElement.previousElementSibling
                const productName = productInfo.querySelector('.product-name').textContent
                const productBrand = productInfo.querySelector('.product-brand').textContent
                const productPrice = productInfo.querySelector('.product-price span').textContent
                const productQtyHolder = btn.closest('.product').querySelector('span.quantity-value')
                const productQtyValue = productQtyHolder.textContent
                const productImage = btn.parentElement.parentElement.querySelector('.img-holder img').src
                soundEffect.play();
                removeAlerts()

                if (cart.length === 0) {
                    // If the cart is empty we add the product directly because it's the first so there is no duplication in this case
                    const Product = {
                        id: productId,
                        name: productName,
                        price: parseFloat(productPrice).toFixed(3),
                        brand: productBrand,
                        image: productImage,
                        quantity: 1,
                    }

                    cart.push(Product)


                    updateCart()
                    updateDataCount(cart.length)
                    calcTotal()
                    setInputsValues()
                } else {

                    const existingProduct = cart.find((product) => product.id === productId);
                    if (existingProduct) {

                        existingProduct.quantity += 1;

                        updateCart()
                        updateDataCount(cart.length)
                        calcTotal()
                        setInputsValues()
                        return;
                    }
                    // If there isn't a product with the same id that we have let's create a product and add it to the cart
                    const Product = {
                        id: productId,
                        name: productName,
                        price: parseFloat(productPrice).toFixed(3),
                        brand: productBrand,
                        image: productImage,
                        quantity: 1,

                    }
                    cart.push(Product)

                    updateDataCount(cart.length)
                    updateCart()
                    calcTotal()
                    setInputsValues()
                }

            })
        })

        function updateCart() {
            tbody.innerHTML = ''
            cart.forEach((product) => {
                const tr = document.createElement('tr');
                tr.setAttribute('data-productid', product.id)
                // Create the <td> elements and set their content and attributes
                const deleteCell = document.createElement('td');
                const deleteButton = document.createElement('button');
                deleteButton.classList.add('delete-button');
                deleteButton.innerHTML = '<i class="fa-light fa-trash"></i>';
                deleteCell.appendChild(deleteButton);

                const imageCell = document.createElement('td');
                const image = document.createElement('img');
                image.src = product.image;
                image.setAttribute('loading', 'lazy')

                imageCell.appendChild(image);

                const productNameCell = document.createElement('td');
                const productNameLink = document.createElement('a');
                productNameLink.href = `${baseUrl}seller/products/details/${product.id}`;
                productNameLink.textContent = product.name;
                productNameCell.appendChild(productNameLink);

                const productPriceCell = document.createElement('td');
                productPriceCell.textContent = product.price;

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
    </script>
    <script>
        const cartForm = document.getElementById('cart-form')
        cartForm.addEventListener('submit', (e) => {
            e.preventDefault()
        })
        const submitBtn = document.getElementById('submitBtn')
        const cartErrorMessage = document.getElementById('error-message')
        submitBtn.addEventListener('click', () => {
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
        // const totalTDs = Array.from(document.querySelectorAll('.totalTD'))

        const minusBtns = document.querySelectorAll('.minusBtn')


        tbody.addEventListener('click', (event) => {
            if (event.target.classList.contains('minusBtn')) {
                const quantityInput = event.target.nextElementSibling;
                if (quantityInput.value != 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                    calcProductTotal(quantityInput);

                    decreaseProductQuantity(quantityInput.closest('tr').dataset.productid, 1)
                    setInputsValues()
                    soundEffect.play();
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
                soundEffect.play();
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
    </script>
    <script>
        tbody.addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-button')) {
                const row = event.target.closest('tr');

                const productId = row.dataset.productid;

                // Remove the product from the cart
                removeProduct(productId);

                // Remove the row from the table
                row.remove();
                soundEffect.play();

                // Recalculate the total
                calcTotal();
                setInputsValues()
            }
        });

        function removeProduct(productId) {
            // Remove the product with the given productId from the cart
            const index = cart.findIndex((product) => product.id === productId);
            if (index !== -1) {
                cart.splice(index, 1);

                updateDataCount(cart.length)
            }
        }
    </script>
    <script>
        saleCart.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                saleCart.classList.remove('modal')
                document.body.classList.remove('no-scroll')

            }
        })
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
        const resetButton = document.getElementById('resetBtn');

        resetButton.addEventListener('click', () => {
            // Empty the cart array
            cart = [];

            // Clear the tbody

            tbody.innerHTML = '';

            modalHolder.classList.remove('show')
            document.body.classList.remove('no-scroll')
            updateDataCount(cart.length)

            // Recalculate the total
            calcTotal();
            setInputsValues()
        });
    </script>


    <script>
        function setInputsValues() {
            cartInput.value = JSON.stringify(cart)
            // console.log("file: seller_sale_add.html:940 ~ setInputsValues ~ cartInput:", cartInput)
            // cartItemsCount.value = cart.length
            // console.log("file: seller_sale_add.html:941 ~ setInputsValues ~ cartItemsCount:", cartItemsCount)
            // let cartAmountValue = document.getElementById('total-span').textContent
            // cartAmount.value = parseFloat(cartAmountValue).toFixed(3)
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
    </script>
    <script>
        const mode = sessionStorage.getItem("mode");
        if (mode) {
            enableDarkMode();
        }

        function enableDarkMode() {
            document.body.classList.add("dark");
            sessionStorage.setItem("mode", "dark");

        }
    </script>

    <script>
        var categoryRadios = document.getElementsByName('category');
        var searchInput = document.getElementById('searchInput');

        categoryRadios.forEach(function(btn) {
            btn.addEventListener('change', function() {
                filterProducts();
            });
        });

        searchInput.addEventListener('input', function() {
            filterProducts();
        });

        function filterProducts() {
            // Get the selected category value
            var selectedCategory = getSelectedCategory();

            // Get the search keyword
            var keyword = searchInput.value.toLowerCase();

            // Get all product elements
            var products = document.getElementsByClassName('product');

            // Loop through the products and filter based on the category and search filters
            Array.from(products).forEach(function(product) {
                // Get the product name element
                var productNameElement = product.querySelector('.product-name');

                // Get the product name
                var productName = productNameElement.textContent.toLowerCase();

                // Get the product category
                var productCategory = product.getAttribute('data-category');

                // Check if the product matches the category and search filters
                var categoryMatch = (product.classList.contains(selectedCategory));
                var searchMatch = (productName.includes(keyword));

                if (categoryMatch && searchMatch) {
                    // Display the product
                    product.style.display = 'block';
                } else {
                    // Hide the product
                    product.style.display = 'none';
                }
            });
        }

        function getSelectedCategory() {
            var category = document.querySelector('input[name=category]:checked');
            return category.value

        }
    </script>


</body>

</html>

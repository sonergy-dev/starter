<style>
.dropdown-menu {
    left: -55%;
}
.dropdown-item {
    padding: .25rem 15px;
}
</style>

<nav class="navbar navbar-expand-lg  navbar-light">
    <div class="container-fluid">
        <a href="/"> <img src="/public/static/assets/company/logo.png" alt="Logo" style="width: 150px;" class="img-fluid"></a>
        <button class="d-inline-block d-lg-none ml-auto btn btn-warning" type="button" id="sidebarCollapse" aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="nav navbar-nav ml-auto">
                <form class="form-inline my-2 my-lg-0" action="/phones_result" method="get">
                    <div class="input-group brand-search mr-2">
                        <div class="input-group-prepend search-icon">
                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search Phone" name="search_input" aria-label="" aria-describedby="basic-addon1">
                    </div>
                    <button class="btn btn-orange nav-btn my-2 my-sm-0" type="submit">Search</button>
                </form>
                <li class="nav-item active">
                    <a class="nav-link text-dark" href="#" data-toggle="modal" data-target="#allStates"><i class="fas fa-map-marker-alt"></i> All Nigeria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="/list_order/"><i class="fas fa-fire"></i> List Buy Order</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link text-dark" href="#" style="position:relative"><i class="fas fa-bell" style="position:relative"><span class="badge1">4</span></i> Notification</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" style="position:relative" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell" style="position:relative"><span class="badge1">4</span></i> Notification
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/my_account/"><i class="fas fa-user-alt mr-1"></i> My Account</a>
                        <a class="dropdown-item" href="/orders/"><i class="fas fa-box mr-1"></i> Orders</a>
                        <a class="dropdown-item" href="/wallet/"><i class="fas fa-wallet mr-1"></i> Wallet</a>
                        <a class="dropdown-item" href="/my_listing/"><i class="fas fa-business-time mr-1"></i> My Listings</a>
                        <a class="dropdown-item" href="/messages/"><i class="far fa-comments mr-1"></i> Messages</a>
                        <a class="dropdown-item" href="/vault/"><i class="fas fa-shield-alt mr-1"></i> Vault</a>
                        <a class="dropdown-item" href="#">LOGOUT</a>
                    </div>
                </li>
                <?php
                    if (!isset($_COOKIE['walletId'])) {
                        // $walletId = $_COOKIE['walletId'];
                ?>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" id="connectWalletModalbtn" data-toggle="modal" data-target="#connectWalletModal"><i class="fas fa-wallet"></i> Wallet</a>
                </li>
                <?php
                    } else {
                ?>
                <?php
                    }
                ?>

            </ul>
        </div>
    </div>
</nav>
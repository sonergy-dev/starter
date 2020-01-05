App = {
  web3Provider: null,
  contracts: {},

  init: function() {
    //   // load articlesRow
    //   var articlesRow = $('#articlesRow');
    //   var articleTemplate = $('#articleTemplate');

    //   articleTemplate.find('.panel-title').text('article 1');
    //   articleTemplate.find('.article-description').text('Desription for article 1');
    //   articleTemplate.find('.article-price').text("10.23");
    //   articleTemplate.find('.article-seller').text("0x1234567890123456890");

    //   articlesRow.append(articleTemplate.html());

    return App.initWeb3();
  },

  initWeb3: function() {
    if (getCookie("login-type") == "Metamask") {
      if (typeof web3 !== "undefined") {
        // Use Mist/MetaMask's provider.
        App.web3Provider = web3.currentProvider;
      } else {
        // Handle the case where the user doesn't have web3. Probably
        // show them a message telling them to install Metamask in
        // order to use the app.
      }
    } else if (getCookie("login-type") == "Fortmatic") {
      let fm = new Fortmatic("pk_test_6F130F20E3DCBF60");
      App.web3Provider = fm.getProvider();
    }
    web3 = new Web3(App.web3Provider);
    web3.currentProvider
      .enable()
      .then(function(accounts) {
        web3.eth.getCoinbase((error, coinbase) => {
          if (error) throw error;
          setCookie("walletId", coinbase, 2);
          if ($("#connectWalletModal").hasClass("show")) {
            $("#connectWalletModalbtn").trigger("click");
            $("#loginBtns").show();
            $("#spinnerLoader").hide();
          }
        });
      })
      .catch(function(reason) {
        // Handle error. Likely the user rejected the login:
        console.log(reason === "User rejected provider access");
      });

    return App.initContract();
  },

  initContract: function() {
    /*
     * Replace me...
     */
  }
};

if (checkCookie("login-type")) {
  App.init();
}
function enableWalletProvider(id) {
  $("#loginBtns").hide();
  $("#spinnerLoader").show();

  setCookie("login-type", id, 2);
  App.init();
}

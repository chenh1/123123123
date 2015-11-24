var User = function(){

    this.userData;

    this.initializeSession = function(){

        var currentUser = this;

        $(".registerBox").hide();

        $(".mainContent").on("click", ".registerOpen", function(e){
            e.preventDefault();
            $(".registerBox").slideToggle();
        });

        $(".loginBtn").click(function(e){
            e.preventDefault();
            var username = $("#username").val();
            var password = $("#password").val();
            $(".loginInput input").val("");
            currentUser.login(username, password);
        });

        $(".register").click(function(e){
            e.preventDefault();
            var firstName = $("#firstName").val();
            var lastName = $("#lastName").val();
            var email = $("#regEmail").val();
            var username = $("#regUsername").val();
            var password = $("#regPassword").val();
            var worker = $("#worker").is(":checked") ? 1 : 0;
            var city = $("#regCity").val();
            $(".registerInput input").val("");
            currentUser.register(firstName, lastName, email, username, password, worker, city);
        });

        $("#logout, #logoutMobile").click(function(){
            currentUser.logout();
        });

        $(".navItem").click(function(){
            var page = $(this).attr("page-link");
            currentUser.accessPage(page);
        })

    };

    this.loginCheck = function(){
        var currentUser = this;
        var loginCheckInfo = {
            loadType: "loginCheck"
        };
        $.ajax({
            method: 'post',
            dataType: 'json',
            data: loginCheckInfo,
            url: 'phpconnect/userhandle.php',
            success: function(response){
                console.log(response);
                currentUser.userData = response;
            },
            error: function(){
                console.log("Could not perform this function");
            }
        });
    };

    this.login = function(username, password){
        var currentUser = this;
        var loginInfo = {
            username: username,
            password: password,
            loadType: "login"
        };
        $.ajax({
            method: 'post',
            dataType: 'json',
            data: loginInfo,
            url: 'phpconnect/userhandle.php',
            success: function(response){
                console.log(response);
                location.reload();
                currentUser.userData = response;
            },
            error: function(){
                console.log("Could not perform this function");
            }
        });
    };

    this.register = function(firstName, lastName, email, username, password, worker, city){
        var currentUser = this;
        var registerInfo = {
            firstName: firstName,
            lastName: lastName,
            email: email,
            username: username,
            password: password,
            worker: worker,
            city: city,
            loadType: "register"
        };
        $.ajax({
            method: 'post',
            data: registerInfo,
            url: 'phpconnect/userhandle.php',
            success: function(){
                $(".registerBox").slideUp();
                currentUser.login(username, password);
            },
            error: function(){
                console.log("Could not perform this function");
            }
        });
    };

    this.logout = function(){
        var logoutInfo = {
            loadType: "logout"
        };
        $.ajax({
            method: 'post',
            data: logoutInfo,
            url: 'phpconnect/userhandle.php',
            success: function(){
                location.reload();
            },
            error: function(){
                console.log("Could not perform this function");
            }
        });
    };

    this.accessPage = function(page){
        var currentUser = this;
        $.ajax({
            method: 'get',
            dataType: 'html',
            url: "pages/" + page,
            success: function(data){
                console.log(data);
                $(".requestContent").remove();
                $(".mainContent").append(data);

                if(page == "shop.php"){
                    $(".makeOrder").click(function(){
                        var city = $(this).attr("city");
                        var address = $(this).attr("address");
                        var store = $(this).text();
                        console.log(city);
                        currentUser.makeOrder(city, address, store);
                    })
                } else if (page == "work.php"){
                    currentUser.listOrders();
                }
            },
            error: function(){
                console.log("Could not perform this function");
            }
        });
    };

    this.makeOrder = function(city, address, store){
        var currentUser = this;
        var orderInfo = {
            city: city,
            address: address,
            store: store,
            userid: currentUser.userData.id,
            username: currentUser.userData.username,
            loadType: "newOrder"
        };
        $.ajax({
            method: 'post',
            dataType: 'json',
            data: orderInfo,
            url: 'phpconnect/order.php',
            success: function(response){
                console.log(response);
            },
            error: function(){
                console.log("Could not perform this function");
            }
        });
    };

    this.listOrders = function(){
        var currentUser = this;
        var workerInfo = {
            city: currentUser.userData.city,
            loadType: "listOrders"
        };
        $.ajax({
            method: 'post',
            dataType: 'json',
            data: workerInfo,
            url: 'phpconnect/order.php',
            success: function(response){
                console.log(response);
                var listLength = response.length;
                var requestContent = $(".requestContent");

                for (var i = 0; i < listLength; i++){
                    var orderBox = $("<div>", {
                        class: "orderBox"
                    });
                    var orderid = $("<div>", {
                        html: response[i].id,
                        class: "col-xs-3"
                    });
                    var reqUser = $("<div>", {
                        html: response[i].username,
                        class: "col-xs-3"
                    });
                    var store = $("<div>", {
                        html: response[i].store,
                        class: "col-xs-3"
                    });
                    var address = $("<div>", {
                        html: response[i].address,
                        class: "col-xs-3"
                    });
                    orderBox.append(orderid, reqUser, store, address);
                    requestContent.append(orderBox);
                }
            },
            error: function(){
                console.log("Could not perform this function");
            }
        });
    };
};

$(document).ready(function(){

    var currentUser = new User();

    currentUser.initializeSession();

    currentUser.loginCheck();

});

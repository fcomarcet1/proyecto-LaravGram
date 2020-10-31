var url = "http://proyecto-laravel.com.devel";

window.addEventListener("load", function () {
    //test Jquery
    //alert("La pagina esta completamente cargada");
    //$('body').css('background','red');

    //CAMBIAR PUNTERO CUANDO PASEMOS POR ENCIMA EL RATON
    $(".btn-like").css("cursor", "pointer");
    $(".btn-dislike").css("cursor", "pointer");

    //BOTON LIKE
    function like() {
        $(".btn-like")
            .unbind("click")
            .click(function () {
                console.log("like");

                // le cambiamos la clase.
                $(this).addClass("btn-dislike").removeClass("btn-like");

                //cambiamos el attr src de la img.
                $(this).attr("src", url + "/img/heart-red.png");

                //PETICION AJAX
                $.ajax({
                    //url: url+'/like/'+$(this).attr('data-id'), // creo k es similar
                    url: url + "/like/" + $(this).data("id"),
                    type: "GET",
                    success: function (response) {
                        if (response.like) {
                            console.log("Has dado like");
                        } else {
                            console.log("ERROR al dar like");
                        }
                    },
                });

                dislike();
            });
    }
    like();

    //BOTON DISLIKE
    function dislike() {
        $(".btn-dislike")
            .unbind("click")
            .click(function () {
                console.log("dislike");

                // le cambiamos la clase.
                $(this).addClass("btn-like").removeClass("btn-dislike");

                //cambiamos el attr src de la img.
                $(this).attr("src", url + "/img/heart-black.png");

                //PETICION AJAX
                $.ajax({
                    //url: url+'/like/'+$(this).attr('data-id'), // creo k es similar
                    url: url + "/dislike/" + $(this).data("id"),
                    type: "GET",
                    success: function (response) {
                        if (response.like) {
                            console.log("Has dado dislike");
                        } else {
                            console.log("ERROR al dar dislike");
                        }
                    },
                });

                like();
            });
    }

    dislike();
	
//	
//	// BUSCADOR
//	$('#buscador').submit(function(e){
//		e.preventDefault();
//		$(this).attr('action', url+'/gente/'+$('#buscador #search').val());
//	});
	
	
	
});

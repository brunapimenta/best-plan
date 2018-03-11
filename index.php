<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Full-Stack PHP">
        <meta name="author" content="Bruna Pimenta">

        <title>Best Plan | Broadband</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="pricing.css" rel="stylesheet">
    </head>
    <body>

        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
            <h5 class="my-0 mr-md-auto font-weight-normal">Best Plan</h5>
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-dark" href="#" data-toggle="modal" data-target="#aboutModal">About</a>
            </nav>
        </div>

        <div class="pricing-header px-3 py-3 pt-md-2 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Pricing</h1>
            <p class="lead">One of the issues when selecting a new telecom bundle for your house is the amount of possibilities to combine plans and bundles to get what you need.</p>
        </div>

        <div class="container">
            <div class="progress" style="display: none;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
            </div>

            <div id="pricingDiv"></div>

            <footer class="pt-4 my-md-5 pt-md-5 border-top">
                <div class="row">
                    <div class="col-12 col-md">
                        <small class="d-block mb-3 text-muted">Bruna Pimenta &copy; 2018</small>
                    </div>
                </div>
            </footer>
        </div>


        <!-- Bootstrap core JavaScript ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                getAllBroadbands();

                $('#linkTryAgain').off('click').on('click', function(e) {
                    e.preventDefault();
                    getAllBroadbands();
                });
            });

            function getAllBroadbands() {
                $('.progress').fadeIn(function() {
                    $.ajax({
                        url: 'api/list-all-broadband',
                        dataType: 'json',
                    })
                    .done(function(broadbands) {
                        listAllBroadbands(broadbands);
                    })
                    .fail(function() {
                        $('.progress').fadeOut(function() {
                            $('#pricingDiv').html('<div class="alert alert-danger text-center" role="alert">Oops! Something went wrong :(<br>You can try it again, just <a id="linkTryAgain" href="#">click here</a>.</div>');
                        });
                    });
                });
            }

            function listAllBroadbands(broadbands) {
                var html = '';
                if ($.isEmptyObject(broadbands) === false) {
                    html = '<div class="card-deck mb-3 text-center">';
                        $.each(broadbands, function(index, broadband) {
                            html += '<div class="card mb-4 box-shadow">';
                                html += '<div class="card-header">';
                                    html += '<h4 class="my-0 font-weight-normal">' + broadband.title + '</h4>';
                                html += '</div>';
                                html += '<div class="card-body">';
                                    html += '<h1 class="card-title pricing-card-title">';
                                        html += 'R$' + broadband.price;
                                        html += '<small class="text-muted">/ mo</small>';
                                    html += '</h1>';
                                    if (broadband.items.length > 1) {
                                        html += '<ul class="list-unstyled mt-3 mb-4">';
                                            html += '<li>' + broadband.items.join('</li><li>') + '</li>';
                                        html += '</ul>';
                                    }
                                    // <button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button>
                                html += '</div>';
                            html += '</div>';
                        });
                    html += '</div>';
                } else {
                    html = '<p class="text-center">None register found :(</p>';
                }

                $('.progress').fadeOut(function() {
                    $('#pricingDiv').html(html);
                });
            }
        </script>

        <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aboutModalLabel">About</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>

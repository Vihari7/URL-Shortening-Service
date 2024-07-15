<?php require "config.php"; ?>

<?php 

    if(isset($_GET['id'])) {
        $id = $_GET['id'];


        $select = $conn->query("SELECT * FROM urls WHERE id='$id'");
        $select->execute();

        $data = $select->fetch(PDO::FETCH_OBJ);

        $clicks = $data->clicks + 1;

        $update = $conn->prepare("UPDATE urls SET clicks = :clicks WHERE id = '$id'");
        $update->execute([
            ':clicks' => $clicks
        ]);

        




        header("location: ".$data->url."");
    }


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style>
            body {overflow: hidden;}
            
            .margin {
                margin-top: 200px
            }
        </style>
    </head>
    <body>
       
        <div class="conatiner">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <form class="card p-2 margin">
                        <div class="input-group">
                        <input type="text" class="form-control" placeholder="your url">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success">Shorten</button>
                        </div>
                        </div>
                    </form>
                </div>
           </div>
        </div>

        <div class="conatiner">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <table class="table mt-4">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            </tr>
                            <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            </tr>
                            <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                 </div>
             </div>
        </div>
    
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
        <!-- Core theme JS-->
    </body>
</html>


<?php

    /*  
      ini_set('display_errors', true);
      error_reporting(E_ALL); 
     */
  
    require_once('lib/nusoap.php');
    $error  = '';
    $result = array();
    $response = '';
    $wsdl = "http://localhost/ws-nusoap/server.php?wsdl";
    if(isset($_POST['sub'])){
        $isbn = trim($_POST['isbn']);
        if(!$isbn){
            $error = 'ISBN tidak boleh kosong.';
        }

        if(!$error){
            //create client object
            $client = new nusoap_client($wsdl, true);
            $err = $client->getError();
            if ($err) {
                echo '<h2>Ada Kesalahan</h2>' . $err;
                // At this point, you know the call that follows will fail
                exit();
            }
             try {
                $result = $client->call('fetchBookData', array($isbn));
                $result = json_decode($result);
              }catch (Exception $e) {
                echo 'Pengecualian Terbaca : ',  $e->getMessage(), "\n";
             }
        }
    }   

    /* Add new book **/
    if(isset($_POST['addbtn'])){
        $title = trim($_POST['title']);
        $isbn = trim($_POST['isbn']);
        $author = trim($_POST['author']);
        $category = trim($_POST['category']);
        $price = trim($_POST['price']);

        //Perform all required validations here
        if(!$isbn || !$title || !$author || !$category || !$price){
            $error = 'Semua kolom yang diperlukan.';
        }

        if(!$error){
            //create client object
            $client = new nusoap_client($wsdl, true);
            $err = $client->getError();
            if ($err) {
                echo '<h2>Ada Kesalahan</h2>' . $err;
                // At this point, you know the call that follows will fail
                exit();
            }
             try {
                /** Call insert book method */
                 $response =  $client->call('insertBook', array($title, $author, $price, $isbn, $category));
                 $response = json_decode($response);
              }catch (Exception $e) {
                echo 'Pengecualian Terbaca : ',  $e->getMessage(), "\n";
             }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Toko Buku | Web Service NuSoap</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <br><h2 class="text-center">Toko Buku | Web Service NuSoap</h2>
        <p class="text-center">Masukan <strong>Kode ISBN</strong> Buku dan Klik <strong>Tombol Cari</strong>.</p><br>

        <div class="row ml-5">
            <form class="form-inline" method = 'post' name='form1'>
                <?php if($error) { ?> 
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong>&nbsp;<?php echo $error; ?> 
                    </div>
                <?php } ?>
                <div class="form-group">
                    <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Enter ISBN" required>
                </div> 
                <button type="submit" name='sub' class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg> Cari</button>
            </form>
        </div>

        <!-- Awal Card Tabel -->
        <div class="card mt-3 ml-5 mr-5">
          <div class="card-header bg-dark text-white">
            Informasi Buku
          </div>
          <div class="card-body">
            
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Judul Buku</th>
                        <th class="text-center">Pengarang</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">ISBN</th>
                        <th class="text-center">Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result){ ?>
                        <tr>
                            <td class="text-center"><?php echo $result->title; ?></td>
                            <td class="text-center"><?php echo $result->author_name; ?></td>
                            <td class="text-center"><?php echo $result->price; ?></td>
                            <td class="text-center"><?php echo $result->isbn; ?></td>   
                            <td class="text-center"><?php echo $result->category; ?></td>
                        </tr>
                        <?php 
                    }else { ?>
                    <tr>
                        <td colspan='5' class="text-center">Masukan <strong>Kode ISBN</strong> Buku dan Klik <strong>Tombol Cari</strong>.</td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>

          </div>
        </div><br><br>
        <!-- Akhir Card Tabel -->

        <!-- Awal Card Form -->
        <div class="card mt-1 ml-5 mr-5">
          <div class="card-header bg-dark text-white">
            Form Informasi Buku
          </div>

          <?php if(isset($response->status)) {

                if($response->status == 200){ ?>
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong>&nbsp; Book Added succesfully. 
                    </div>
                <?php }elseif(isset($response) && $response->status != 200) { ?>
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong>&nbsp; Cannot Add a book. Please try again. 
                    </div>
                <?php } 
            }
            ?>

          <div class="card-body">
            <form method="post" name='form1'>
                <?php if($error) { ?> 
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong>&nbsp;<?php echo $error; ?> 
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Masukan Judul Buku" required>
                </div>
                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" name="author" id="author" class="form-control" placeholder="Masukan Pengarang" required>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="Masukan Harga" required>
                </div>
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Masukan ISBN" required>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <input type="text" name="category" id="category" class="form-control" placeholder="Masukan Kategori" required>
                </div>

                <button type="submit" name='addbtn' class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
                    <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                </svg> Simpan</button>
            </form>
          </div>
        </div>
        <!-- Akhir Card Form -->
    </div><br><br>

    <footer class="text-center">
        <p>&copy; Kelompok Web Services - 2021</p>
    </footer>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
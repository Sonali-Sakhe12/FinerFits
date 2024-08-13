<?php
require_once("include/initialize.php");
$mydb->setQuery("SELECT * FROM tblcart c,tblproduct p where user = '".session_id()."' and c.PROID=p.PROID");
$cur = $mydb->loadResultList();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Home @ FinerFits</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="#" name="keywords">
    <meta content="#" name="description">
    <link rel="apple-touch-icon" sizes="57x57" href="img/favicons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="img/favicons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/favicons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/favicons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/favicons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/favicons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="img/favicons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="img/favicons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="img/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicons/favicon-16x16.png">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 
    <link
            href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <?php
    include('header.php');
    ?>
    <!-- Topbar End -->
    
    <!-- Page Header Start -->
    <!-- <div class="container-fluid d-flex align-items-center justify-content-center flex-column text-center px-0 mt-3">
        <div class="table-container">
            <h3 class="table-title py-1" style="background-color:#d1d3d4;">Vest Size Chart</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SIZE</th>
                        <th>FINERFITS</th>
                        <th>COATCHEST</th>
                        <th>SHOULDER</th>
                        <th>VEST LENGTH</th>
                        <th>BELLY</th>
                        <th>WAIST</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>XXS</td>
                        <td>34</td>
                        <td>34</td>
                        <td>16.5</td>
                        <td>24.5</td>
                        <td>31</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>XS</td>
                        <td>36</td>
                        <td>36</td>
                        <td>17</td>
                        <td>25</td>
                        <td>33</td>
                        <td>32</td>
                    </tr>
                    <tr>
                        <td>S</td>
                        <td>38</td>
                        <td>38</td>
                        <td>18</td>
                        <td>26</td>
                        <td>35</td>
                        <td>34</td>
                    </tr>
                    <tr>
                        <td>M</td>
                        <td>40</td>
                        <td>40</td>
                        <td>18.5</td>
                        <td>26</td>
                        <td>37</td>
                        <td>36</td>
                    </tr>
                    <tr>
                        <td>L</td>
                        <td>42</td>
                        <td>42</td>
                        <td>19</td>
                        <td>27</td>
                        <td>39</td>
                        <td>38</td>
                    </tr>
                    <tr>
                        <td>XL</td>
                        <td>44</td>
                        <td>44</td>
                        <td>19.5</td>
                        <td>27</td>
                        <td>41</td>
                        <td>40</td>
                    </tr>
                    <tr>
                        <td>2XL</td>
                        <td>46</td>
                        <td>46</td>
                        <td>20</td>
                        <td>27</td>
                        <td>43</td>
                        <td>42</td>
                    </tr>
                    <tr>
                        <td>3XL</td>
                        <td>48</td>
                        <td>48</td>
                        <td>21</td>
                        <td>27.5</td>
                        <td>45</td>
                        <td>44</td>
                    </tr>
                    <tr>
                        <td>4XL</td>
                        <td>50</td>
                        <td>50</td>
                        <td>21.5</td>
                        <td>27.5</td>
                        <td>47</td>
                        <td>46</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-container">
        <h3 class="table-title py-1" style="background-color:#d1d3d4;">Blazer, Coat+Vest Size Chart</h2>
            <table class="table table-bordered border-dark">
                <thead>
                    <tr>
                        <th>SIZE</th>
                        <th>FINERFITS</th>
                        <th>COATCHEST</th>
                        <th>SHOULDER</th>
                        <th>SLEEVE LENGTH</th>
                        <th>BELLY</th>
                        <th>WAIST</th>
                        <th>HIP</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>XXS</td>
                        <td>34</td>
                        <td>34</td>
                        <td>16.5</td>
                        <td>23.5</td>
                        <td>31</td>
                        <td>30</td>
                        <td>35</td>
                    </tr>
                    <tr>
                        <td>XS</td>
                        <td>36</td>
                        <td>36</td>
                        <td>17</td>
                        <td>24</td>
                        <td>33</td>
                        <td>32</td>
                        <td>37</td>
                    </tr>
                    <tr>
                        <td>S</td>
                        <td>38</td>
                        <td>38</td>
                        <td>18</td>
                        <td>24.5</td>
                        <td>35</td>
                        <td>34</td>
                        <td>39</td>
                    </tr>
                    <tr>
                        <td>M</td>
                        <td>40</td>
                        <td>40</td>
                        <td>18.5</td>
                        <td>24.5</td>
                        <td>37</td>
                        <td>36</td>
                        <td>41</td>
                    </tr>
                    <tr>
                        <td>L</td>
                        <td>42</td>
                        <td>42</td>
                        <td>19</td>
                        <td>25</td>
                        <td>39</td>
                        <td>38</td>
                        <td>43</td>
                    </tr>
                    <tr>
                        <td>XL</td>
                        <td>44</td>
                        <td>44</td>
                        <td>19.5</td>
                        <td>25.5</td>
                        <td>41</td>
                        <td>40</td>
                        <td>45</td>
                    </tr>
                    <tr>
                        <td>2XL</td>
                        <td>46</td>
                        <td>46</td>
                        <td>20</td>
                        <td>26</td>
                        <td>43</td>
                        <td>42</td>
                        <td>47</td>
                    </tr>
                    <tr>
                        <td>3XL</td>
                        <td>48</td>
                        <td>48</td>
                        <td>21</td>
                        <td>26</td>
                        <td>45</td>
                        <td>44</td>
                        <td>49</td>
                    </tr>
                    <tr>
                        <td>4XL</td>
                        <td>50</td>
                        <td>50</td>
                        <td>21.5</td>
                        <td>26.5</td>
                        <td>47</td>
                        <td>46</td>
                        <td>51</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-container">
            <h2 class="table-title">Table 1</h2>
            <table class="table table-bordered border-dark">
                <thead>
                    <tr>
                        <th>Header 1</th>
                        <th>Header 2</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Data 1</td>
                        <td>Data 2</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> -->
    <div class="container-fluid p-0">
        <img src="img/sizecharttable1.jpg" alt="size chart table 1" style="width:100%;"/>
        <img src="img/sizecharttable2.jpg" alt="size chart table 2" style="width:100%;"/>
        <img src="img/sizecharttable3.jpg" alt="size chart table 3" style="width:100%;"/>
    </div>
    <!-- Page Header End -->

    <!-- Footer Start -->
    <?php
    include('footer.php');
    ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <!-- <script src="js/main.js"></script> -->
    <script>
        function remove(id){
        const base = window.location.origin
        fetch(base+"/FinerFits/cartfunction.php", {
        method:'post',
        body: JSON.stringify({
        id: id,
        user: '<?= session_id()?>',
        mode: 'remove'
        }),
        headers: {
        'Content-Type': 'application/json'
        }
        }).then((response)=>{
        return response.json()
        }).then((res)=>{
        if(res.status == 1){
        location.reload()
        }else{
        alert(res.msg)
        }
        }).catch((error)=>{
        console.log(error)
        })
        }

        function plus(id){
            const base = window.location.origin
            fetch(base+"/FinerFits/cartfunction.php", {
            method:'post',
            body: JSON.stringify({
            id: id,
            user: '<?= session_id()?>',
            mode: 'plus'
            }),
            headers: {
            'Content-Type': 'application/json'
            }
            }).then((response)=>{
            return response.json()
            }).then((res)=>{
            if(res.status == 1){
            location.reload()
            }else{
            alert(res.msg)
            }
            }).catch((error)=>{
            console.log(error)
            })
        }

        function minus(id){
            const base = window.location.origin
            fetch(base+"/FinerFits/cartfunction.php", {
            method:'post',
            body: JSON.stringify({
            id: id,
            user: '<?= session_id()?>',
            mode: 'minus'
            }),
            headers: {
            'Content-Type': 'application/json'
            }
            }).then((response)=>{
            return response.json()
            }).then((res)=>{
            if(res.status == 1){
            location.reload()
            }else{
            alert(res.msg)
            }
            }).catch((error)=>{
            console.log(error)
            })
        }
    </script>


</body>

</html>
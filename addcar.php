<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

include 'db_connection.php';
$user_id = $_SESSION['user_id'];

$sqlUser = "SELECT  `profile-picture` FROM user WHERE id = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
if ($resultUser->num_rows > 0) {
    $user = $resultUser->fetch_assoc();
    $profilePicture = $user['profile-picture'];
} else {
    $profilePicture = 'images/default_profile.png';
}
$stmtUser->close();
$error = "";

if (isset($_SESSION['add_car_error'])) {
    $error = $_SESSION['add_car_error'];
    unset($_SESSION['add_car_error']);
}


$brands = [
    "Abarth", "Alfa Romeo", "Aston Martin", "Audi", "Bentley", "BMW", "Bugatti", "Cadillac", "Chevrolet", "Chrysler", "Citroën", "Dacia", "Daewoo", "Daihatsu", "Dodge", "DS Automobiles", "Ferrari", "Fiat", "Ford", "Honda", "Hyundai", "Infiniti", "Jaguar", "Jeep", "Kia", "Lada", "Lamborghini", "Lancia", "Land Rover", "Lexus", "Lotus", "Maserati", "Mazda", "McLaren", "Mercedes-Benz", "Mini", "Mitsubishi", "Nissan", "Opel", "Peugeot", "Porsche", "Renault", "Rolls-Royce", "Rover", "Saab", "Seat", "Skoda", "Smart", "SsangYong", "Subaru", "Suzuki", "Tesla", "Toyota", "Volkswagen", "Volvo"
];

$models_by_brand = [
    "Abarth" => ["500", "595", "695", "Punto"],
    "Alfa Romeo" => ["Giulia", "Stelvio", "Giulietta", "Mito", "4C"],
    "Aston Martin" => ["DB11", "Vantage", "DBS Superleggera", "Rapide", "Valhalla"],
    "Audi" => ["A1", "A3", "A4", "A5", "A6", "A7", "A8", "Q2", "Q3", "Q5", "Q7", "Q8", "R8", "TT"],
    "Bentley" => ["Continental GT", "Flying Spur", "Bentayga", "Mulsanne"],
    "BMW" => ["1 Series", "2 Series", "3 Series", "4 Series", "5 Series", "6 Series", "7 Series", "8 Series", "X1", "X2", "X3", "X4", "X5", "X6", "X7", "Z4", "i3", "i8"],
    "Bugatti" => ["Chiron", "Veyron"],
    "Cadillac" => ["CT4", "CT5", "CT6", "XT4", "XT5", "XT6", "Escalade"],
    "Chevrolet" => ["Spark", "Sonic", "Cruze", "Malibu", "Impala", "Camaro", "Corvette", "Equinox", "Traverse", "Suburban", "Tahoe", "Silverado"],
    "Chrysler" => ["300", "Pacifica"],
    "Citroën" => ["C1", "C3", "C4", "C5", "Berlingo", "C3 Aircross", "C5 Aircross"],
    "Dacia" => ["Sandero", "Logan", "Duster"],
    "Daewoo" => ["Matiz", "Lanos"],
    "Daihatsu" => ["Sirion", "Terios"],
    "Dodge" => ["Challenger", "Charger", "Durango", "Grand Caravan"],
    "DS Automobiles" => ["DS 3", "DS 4", "DS 5", "DS 7 Crossback"],
    "Ferrari" => ["F8 Tributo", "SF90 Stradale", "Roma", "Portofino"],
    "Fiat" => ["500", "Panda", "Tipo"],
    "Ford" => ["Fiesta", "Focus", "Mondeo", "Mustang", "Puma", "Kuga", "Explorer", "F-150"],
    "Honda" => ["Jazz", "Civic", "Accord", "CR-V", "HR-V"],
    "Hyundai" => ["i10", "i20", "i30", "i40", "Tucson", "Santa Fe", "Kona"],
    "Infiniti" => ["Q50", "Q60", "QX50", "QX60"],
    "Jaguar" => ["XE", "XF", "XJ", "F-Pace", "E-Pace", "I-Pace", "F-Type"],
    "Jeep" => ["Wrangler", "Compass", "Cherokee", "Grand Cherokee"],
    "Kia" => ["Picanto", "Rio", "Ceed", "Optima", "Sportage", "Sorento"],
    "Lada" => ["Granta", "Vesta"],
    "Lamborghini" => ["Aventador", "Huracan", "Urus"],
    "Lancia" => ["Ypsilon"],
    "Land Rover" => ["Range Rover", "Range Rover Sport", "Range Rover Velar", "Discovery", "Discovery Sport", "Defender", "Evoque"],
    "Lexus" => ["CT", "IS", "ES", "GS", "LS", "UX", "NX", "RX"],
    "Lotus" => ["Elise", "Exige", "Evora"],
    "Maserati" => ["Ghibli", "Quattroporte", "Levante"],
    "Mazda" => ["Mazda2", "Mazda3", "Mazda6", "CX-3", "CX-5", "MX-5"],
    "McLaren" => ["570S", "720S", "GT"],
    "Mercedes-Benz" => ["A-Class", "C-Class", "E-Class", "S-Class", "CLA", "CLS", "GLA", "GLC", "GLE", "GLS", "G-Class", "AMG GT"],
    "Mini" => ["Cooper", "Clubman", "Countryman"],
    "Mitsubishi" => ["Mirage", "Lancer", "Outlander", "Pajero"],
    "Nissan" => ["Micra", "Juke", "Qashqai", "X-Trail", "Leaf", "GT-R"],
    "Opel" => ["Corsa", "Astra", "Insignia", "Mokka", "Crossland", "Grandland"],
    "Peugeot" => ["108", "208", "308", "508", "2008", "3008", "5008"],
    "Porsche" => ["911", "Cayman", "Panamera", "Macan", "Cayenne"],
    "Renault" => ["Clio", "Megane", "Captur", "Kadjar", "Talisman"],
    "Rolls-Royce" => ["Phantom", "Ghost", "Wraith", "Cullinan"],
    "Rover" => [],
    "Saab" => [],
    "Seat" => ["Ibiza", "Leon", "Arona", "Ateca", "Tarraco"],
    "Skoda" => ["Fabia", "Octavia", "Superb", "Kamiq", "Karoq", "Kodiaq"],
    "Smart" => ["Fortwo", "Forfour"],
    "SsangYong" => ["Tivoli", "Korando", "Rexton"],
    "Subaru" => ["Impreza", "Legacy", "Outback", "Forester", "XV"],
    "Suzuki" => ["Swift", "Vitara", "Jimny"],
    "Tesla" => ["Model S", "Model 3", "Model X", "Model Y"],
    "Toyota" => ["Yaris", "Corolla", "Camry", "RAV4", "Highlander", "Land Cruiser", "Hilux", "Prius"],
    "Volkswagen" => ["Polo", "Golf", "Passat", "Tiguan", "Touareg", "Arteon"],
    "Volvo" => ["S60", "S90", "V60", "V90", "XC40", "XC60", "XC90"]
];


$colors = [
    "Red", "Blue", "Green", "Yellow", "Black", "White", "Silver", "Gray", "Brown", "Orange",
    "Purple", "Pink", "Teal", "Navy", "Maroon", "Olive", "Lime", "Aqua", "Fuchsia", "Magenta"
];

$countries = [
    "United Arab Emirates", "Bahrain", "Djibouti", "Egypt", "Iran", "Iraq", "Jordan", "Kuwait", "Lebanon",
    "Libya", "Oman", "Palestine", "Qatar", "Saudi Arabia", "Somalia", "Sudan", "Syria", "Turkey", "Yemen"
];

$cities_by_country = [
    "United Arab Emirates" => ["Abu Dhabi", "Dubai", "Sharjah", "Al Ain", "Ajman"],
    "Bahrain" => ["Manama", "Riffa", "Muharraq", "Hamad Town"],
    "Djibouti" => ["Djibouti City"],
    "Egypt" => ["Cairo", "Alexandria", "Giza", "Shubra El-Kheima", "Port Said"],
    "Iran" => ["Tehran", "Mashhad", "Isfahan", "Tabriz", "Karaj"],
    "Iraq" => ["Baghdad", "Basra", "Mosul", "Erbil", "Kirkuk"],
    "Jordan" => ["Amman", "Irbid", "Zarqa", "Aqaba"],
    "Kuwait" => ["Kuwait City", "Al Jahra", "Hawalli", "Al Ahmadi"],
    "Lebanon" => ["Beirut", "Tripoli", "Sidon", "Tyre"],
    "Libya" => ["Tripoli", "Benghazi", "Misrata", "Tobruk"],
    "Oman" => ["Muscat", "Salalah", "Sohar", "Nizwa"],
    "Palestine" => ["Jerusalem", "Gaza", "Hebron", "Nablus"],
    "Qatar" => ["Doha"],
    "Saudi Arabia" => ["Riyadh", "Jeddah", "Mecca", "Medina", "Dammam"],
    "Somalia" => ["Mogadishu", "Hargeisa", "Kismayo"],
    "Sudan" => ["Khartoum", "Omdurman", "Port Sudan"],
    "Syria" => ["Damascus", "Aleppo", "Homs", "Latakia","Hama","Raqqa","Deir ez-Zor","Al-Hasakah","Idlib","Daraa","As-Suwayda","Al-Qamishli","Jablah","Tartus"],
    "Turkey" => ["Istanbul", "Ankara", "Izmir", "Bursa", "Adana"],
    "Yemen" => ["Sana'a", "Aden", "Taiz", "Hodeida"]
];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarZone - Add Car</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/addcoms.css">
    <link rel="stylesheet" href="./css/addcar.css">
    <link rel = "website icon " type ="png" href ="images/icon.jpg">

</head>
<body>
<nav>
        <h1 data-lang="CarZone">CarZone</h1>
        <ul>
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <?php if ($user['profile-picture']): ?>
                    <img src="<?php echo htmlspecialchars($user['profile-picture']); ?>" alt="Profile Picture" class="rounded-circle" style="width: 30px; height: 30px; margin-right: 5px;">
                <?php else: ?>
                    <img src="images/default_profile.png" alt="Default Profile Picture" class="rounded-circle" style="width: 30px; height: 30px; margin-right: 5px;"> <?php endif; ?>
                </a>
             
            </li>
            <li><a href="profile.php"data-lang="Profile">Add Car</a></li>
            <li><a href="home.php"data-lang="logout"></a></li>
            <li>
                <span data-lang="selectLanguage">Select a language</span>
                <select id="languageSelector" class="p-1 mt-2">
                    <option value="en" data-lang="english" selected >English</option>
                    <option value="ar"data-lang="arabic">Arabic</option>
                </select>
            </li>
        </ul>
    </nav>
</nav>


    <div class="container add-car-container">
        <div class="add-car-form">
            <h2 data-lang="AddNewCar">Add New Car Listing</h2>
            <?php if ($error): ?>
                <p class="error-message"><?php echo $error; ?></p>

            <?php endif; ?>
            <form action="process_add_car.php" method="post" enctype="multipart/form-data" id="addCarForm">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

                <div class="form-group">
                    <label for="brand" data-lang="Brand">Brand:</label>
                    <select id="brand" name="brand" required class="form-control">
                        <option value="">Select Brand</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?php echo htmlspecialchars($brand); ?>"><?php echo htmlspecialchars($brand); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="model" data-lang="Model">Model:</label>
                    <select id="model" name="model" required class="form-control">
                        <option value="">Select Model</option>
                        <?php
                        $firstBrand = reset($brands);
                         if ($firstBrand):
                            foreach ($models_by_brand[$firstBrand] as $model): ?>
                                <option value="<?php echo htmlspecialchars($model); ?>"><?php echo htmlspecialchars($model); ?></option>
                            <?php endforeach;
                         endif;
                         ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="year" data-lang="Year">Year:</label>
                    <input type="number" id="year" name="year" min="1900" max="<?php echo date('Y'); ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="price" data-lang="Price">Price:</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="color" data-lang="Color">Color:</label>
                    <select id="color" name="color" class="form-control">
                        <option value="">Select Color</option>
                        <?php foreach ($colors as $color): ?>
                            <option value="<?php echo htmlspecialchars($color); ?>"><?php echo htmlspecialchars($color); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="country" data-lang="Country">Country:</label>
                    <select id="country" name="country" class="form-control">
                        <option value="">Select Country</option>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo htmlspecialchars($country); ?>"><?php echo htmlspecialchars($country); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="city" data-lang="City">City:</label>
                    <select id="city" name="city" class="form-control">
                        <option value="">Select City</option>
                         <?php
                            $firstCountry = reset($countries);
                            if ($firstCountry):
                                foreach ($cities_by_country[$firstCountry] as $city):
                         ?>
                                <option value="<?php echo htmlspecialchars($city); ?>"><?php echo htmlspecialchars($city); ?></option>
                            <?php
                                endforeach;
                            endif;
                            ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description" data-lang="Description">Description:</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="images" data-lang="CarImages">Images:</label>
                    <div class="image-upload-container">
                        <input type="file" name="images[]" multiple class="form-control-file">
                        <div class="image-preview-container" id="imagePreview">
                        </div>
                    </div>
                    <small class="form-text text-muted" data-lang="Youcanselectmultipleimages">You can select multiple images.</small>
                </div>


                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" data-lang="AddListing">Add Listing</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='profile.php'" data-lang="Cancel">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    const brandDropdown = document.getElementById('brand');
    const modelDropdown = document.getElementById('model');
    const countryDropdown = document.getElementById('country');
    const cityDropdown = document.getElementById('city');
    const modelsByBrand = <?php echo json_encode($models_by_brand); ?>;
    const citiesByCountry = <?php echo json_encode($cities_by_country); ?>;

    brandDropdown.addEventListener('change', function() {
        const selectedBrand = this.value;
        modelDropdown.innerHTML = '<option value="">Select Model</option>';
        if (modelsByBrand[selectedBrand]) {
            modelsByBrand[selectedBrand].forEach(model => {
                modelDropdown.add(new Option(model, model));
            });
        }
    });

    countryDropdown.addEventListener('change', function() {
        const selectedCountry = this.value;
        cityDropdown.innerHTML = '<option value="">Select City</option>';
        if (citiesByCountry[selectedCountry]) {
            citiesByCountry[selectedCountry].forEach(city => {
                cityDropdown.add(new Option(city, city));
            });
        }
    });
    </script>
    <script src="./js/script.js" type="module"></script>
    <script src="./js/addcar.js" ></script>
</body>
</html>

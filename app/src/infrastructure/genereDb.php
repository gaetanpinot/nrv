<?php


$nbUser= 100;
$nbArtiste = 20;
$nbLieu = 10;
$nbSpectacle= 24;
$nbSoire = 13;
$nbBillet = 30;
require_once __DIR__ . '/../../vendor/autoload.php';

$drop = 'drop table if exists spectacle,soiree_panier,billet,spectacle_artistes,soiree,theme,panier,lieu_spectacle,utilisateur,artiste, spectacles_soiree cascade;';
$theme = '
create table theme(
id int primary key,
label varchar(50)
);';

$user = '
create table utilisateur(
id uuid primary key,
email varchar(100),
nom varchar(50),
prenom varchar(50),
password varchar(100),
role int
);';

$panier = '
create table panier(
id uuid primary key,
id_utilisateur uuid not null,
id_billet uuid not null,
is_valide bool not null,
foreign key(id_utilisateur) references utilisateur(id)
);';

$lieu_spectacle = '
create table lieu_spectacle(
id uuid primary key,
nom varchar(50) not null unique,
adresse varchar(150) not null,
nb_places_assises int not null,
nb_places_debout int not null,
lien_image varchar(3000)[] not null
);';

$artiste = '
create table artiste(
id uuid primary key,
prenom varchar(100)
);';

$spactalce =
'
create table spectacle(
id uuid primary key,
titre varchar(100) not null,
description varchar(5000),
url_image varchar(3000) not null,
url_video varchar(2000) not null
);';

$soiree = '
create table soiree(
id uuid primary key,
nom varchar(100) not null,
id_theme int not null,
date date not null,
heure_debut time not null,
duree interval not null,
id_lieu uuid not null,
nb_places_assises_restantes int not null,
nb_places_debout_restantes int not null,
tarif_normal numeric(6,2) not null,
tarif_reduit numeric(6,2) not null,
foreign key(id_lieu) references lieu_spectacle(id),
foreign key(id_theme) references theme(id)
);';

$spectacles_soiree = '
create table spectacles_soiree(
id_spectacle uuid,
id_soiree uuid,
primary key(id_spectacle,id_soiree),
foreign key(id_spectacle) references spectacle(id),
foreign key(id_soiree) references soiree(id)
);';

$spectacles_artistes = 
'create table spectacle_artistes(
id_spectacle uuid ,
id_artiste uuid ,
primary key(id_spectacle,id_artiste),
foreign key(id_artiste) references artiste(id),
foreign key(id_spectacle) references spectacle(id)
);';

$billet = '
create table billet(
id uuid primary key,
id_utilisateur uuid not null,
id_soiree uuid not null,
tarif numeric(6,2) not null,
foreign key(id_utilisateur) references utilisateur(id),
foreign key(id_soiree) references soiree(id)
);';

$soiree_panier = '
create table soiree_panier(
id_soiree uuid ,
id_panier uuid ,
primary key (id_soiree, id_panier),
foreign key(id_soiree) references soiree(id),
foreign key(id_panier) references panier(id)
);';

$config= parse_ini_file(__DIR__ . '/../../config/pdoConfig.ini');
$co =  new PDO($config['driver'].':host='.$config['host'].';port='.$config['port'].';dbname='.$config['dbname'].';user='.$config['user'].';password='.$config['password']);

$co->exec($drop);
$co->exec($theme);
$co->exec($user);
$co->exec($panier);
$co->exec($artiste);
$co->exec($lieu_spectacle);
$co->exec($spactalce);
$co->exec($soiree);
$co->exec($spectacles_artistes);
$co->exec($billet);
$co->exec($soiree_panier);
$co->exec($spectacles_soiree);
$faker = Faker\Factory::create('fr_FR');

$theme=[
	'Rock',
	'Metal',
	'Pop',
	'Jazz'
];

echo "debut theme  \r\n";
$query="insert into theme (id, label) 
values (:id,:label);";
$insert = $co->prepare($query);
$i=1;
foreach($theme as $t){
	$val = [
		'id'=> $i++,
		'label' => $t,
	];
	$insert->execute($val);
}
// email varchar(50) primary key,
// nom varchar(50),
// prenom varchar(50),
// password varchar(50)

echo "debut utilisateur \r\n";
$userID=[];
$query = 'insert into utilisateur
(id, email, nom, prenom, password, role)
values (:id, :email, :nom, :prenom, :password, :role);';
$insert = $co->prepare($query);
for($i = 0; $i<$nbUser ; $i++){

	$nom = $faker->lastName();
	$prenom = $faker->firstName();
	$val = [
		'id' => $faker->uuid(),
		'email' => $faker->email(),
		'nom' =>$nom,
		'prenom' => $prenom,
		'password'=> password_hash("1234",PASSWORD_DEFAULT),
        'role' => 1
	];
	$insert->execute($val);
	$userID[] = $val['id'];
}

// create table panier(
// id uuid primary key,
// email_utilisateur varchar(50) not null,
// is_valide bool not null,
// foreign key(email_utilisateur) references utilisateur(email)
$query = 'insert into panier 
(id, id_utilisateur, id_billet, is_valide)
values (:id, :id, :id, :valide);';


// id uuid primary key,
// prenom varchar(100)
 echo "debut artiste \r\n";
$artisteId= [];
$query = 'insert into artiste
(id, prenom) 
values (:id, :prenom);';
$insert = $co->prepare($query);
for($i=0; $i<$nbArtiste;$i++){
	$val=[
		'id' => $faker->uuid(),
		'prenom' => $faker->firstName(),
	];
	$insert->execute($val);
	$artisteId[]=$val['id'];
}
$lieu_spectacle;

// id uuid primary key,
// nom varchar(50) not null unique,
// adresse varchar(150) not null,
// nb_places_assises int not null,
// nb_places_debout int not null,
// lien_image varchar(3000)[] not null

echo 'debut lieu spectacle \r\n';
$query = 'insert into lieu_spectacle 
(id, nom, adresse, nb_places_assises, nb_places_debout, lien_image)
values (:id, :nom, :adresse, :nb_places_assises, :nb_places_debout, :lien_image);';
$insert = $co->prepare($query);
$lieu = [];
$liensImage = "{'https://upload.wikimedia.org/wikipedia/commons/f/f7/Theatre_Champs_Elysees_35.jpg',
	'https://upload.wikimedia.org/wikipedia/commons/9/93/Gran_Teatro_C%C3%A1ceres.JPG'}";
for($i = 0; $i<$nbLieu; $i++){
	
	$val=[
		'id'=>$faker->uuid(),
		'nom' => "Salle ". $faker->streetName(),
		'adresse' => $faker->address(),
		'nb_places_assises' => $faker->numberBetween(100,200),
		'nb_places_debout' => $faker->numberBetween(200,300),
		'lien_image' => $liensImage,

	];
	try{
		$insert->execute($val);
	}catch(PDOException $e){
		$i--;
	}
	$lieu[]=$val;
}
echo 'fin lieu spectacle';
$spactalce;
// id uuid primary key,
// titre varchar(100) not null,
// description varchar(300),
// url_image varchar(300) not null,
// url_video varchar(100) not null,

echo 'debut spectacle';
$query = '
insert into spectacle
(id, titre, description, url_image, url_video)
values (:id, :titre, :description, :url_image, :url_video);';
$idSpectacle = [];
$insert = $co->prepare($query);
for($i =0; $i<$nbSpectacle; $i++){

	$val = [
		'id' =>$faker->uuid(),
		'titre' => $faker->word(),
		'description' => $faker->paragraph(4),
		'url_image' => 'http://bonplanaparis.com/sortir/wp-content/uploads/2017/01/spectacle.jpg',
		'url_video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
	];
	$insert->execute($val);
	$idSpectacle[] = $val['id'];
}
echo 'fin spectacle';

$soiree;
// id uuid primary key,
// nom varchar(100) not null,
// id_theme int not null,
// date date not null,
// heure_debut time not null,
// duree interval not null,
// id_lieu uuid not null,
// nb_places_assises_restantes int not null,
// nb_places_debout_restantes int not null,
// tarif_normal numeric(6,2) not null,
// tarif_reduit numeric(6,2) not null,
echo 'debut soiree';
$query = '
insert into soiree
(id, nom, id_theme, date, heure_debut, duree, id_lieu, nb_places_assises_restantes, nb_places_debout_restantes, tarif_normal, tarif_reduit)
values (:id, :nom, :id_theme, :date, :heure_debut, :duree, :id_lieu, :nb_places_assises_restantes, :nb_places_debout_restantes, :tarif_normal, :tarif_reduit);';
$insert = $co->prepare($query);
$soireeArray = [];
for($i=0; $i<$nbSoire; $i++){
	$l = $lieu[$faker->numberBetween(0, count($lieu)-1)];
	$val = [
		'id'=> $faker->uuid(),
		'nom'=> $faker->word(),
		'id_theme' => $faker->numberBetween(1,count($theme)),
		'date' => $faker->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d'),
		'heure_debut'=> $faker->dateTimeBetween('today 18:00', 'today 20:30')->format('H:i'),
		'duree' => $faker->dateTimeBetween('today 1:30', 'today 05:00')->format('H:i'),
		'id_lieu' => $l['id'],
		'nb_places_assises_restantes' => $l['nb_places_assises'],
		'nb_places_debout_restantes' => $l['nb_places_debout'],
		'tarif_normal' => $faker->numberBetween(45, 90),
		'tarif_reduit' => $faker->numberBetween(28, 70),
	];
	$insert->execute($val);
	$soireeArray[] = $val;
}
	//var_dump($soireeArray);
echo 'fin soiree';
$spectacles_artistes;
// id_spectacle uuid ,
// id_artiste uuid ,
echo 'debut spectacles artistes';
$query = '
insert into spectacle_artistes
(id_spectacle, id_artiste)
values (:id_spectacle, :id_artiste);';
$insert = $co->prepare($query);
foreach($idSpectacle as $sp){
	for($j = 0; $j<3; $j++){
		$val = [
			'id_spectacle' => $sp,
			'id_artiste' => $artisteId[$faker->numberBetween(0,count($artisteId)-1)],
		];
		try{
			$insert->execute($val);
		}catch(PDOException $e){
		}
	}
}
echo "fin spectacles_artistes";

$billet;
// id uuid primary key,
// email_utilisateur varchar(50) not null,
// id_soiree uuid not null,
// tarif numeric(6,2) not null,
echo "debut billet\r\n";
$query = 'insert into billet
(id, id_utilisateur, id_soiree, tarif)
values (:id, :id_utilisateur, :id_soiree, :tarif);';
$insert = $co->prepare($query);
for($i = 0; $i<$nbBillet; $i++){
	$so = $soireeArray[$faker->numberBetween(0,count($soireeArray)-1)];
	$val = [
		'id' => $faker->uuid(),
		'id_utilisateur' => $userID[$faker->numberBetween(0, count($userID)-1)],
		'id_soiree' => $so['id'],
		'tarif' => $so['tarif_normal']
	];
}
echo "fin billet\r\n";

$spectacles_soiree;
$query = 'insert into spectacles_soiree
(id_spectacle, id_soiree)
values (:id_spectacle, :id_soiree);';
$insert = $co->prepare($query);
foreach($soireeArray as $soir){
	for($i = 0; $i<$faker->numberBetween(2,4);$i++){
		$val = [
			'id_spectacle' => $idSpectacle[$faker->numberBetween(0,count($idSpectacle)-1)],
			'id_soiree' => $soir['id'],
		];
		try{
			$insert->execute($val);
		}catch(PDOException  $e){
		}
	}

}
// on enleve les spectacles qui n'on pas de soiree
$query = "delete from spectacle_artistes where 
spectacle_artistes.id_spectacle not in (select distinct(id_spectacle) from spectacles_soiree);
delete from spectacle where 
spectacle.id not in (select distinct(id_spectacle) from spectacles_soiree);";

$co->exec($query);

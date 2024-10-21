<?php

require_once __DIR__ . '/../../vendor/autoload.php';
$drop = 'drop table if exists spectacle,soiree_panier,billet,spectacle_artistes,soiree,theme,panier,lieu_spectacle,utilisateur,artiste;';
$theme = '
create table theme(
id int primary key,
label varchar(50)
);';
$user = '
create table utilisateur(
email varchar(50) primary key,
nom varchar(50),
prenom varchar(50),
password varchar(50)
);';
$panier = '
create table panier(
id uuid primary key,
email_utilisateur varchar(50) not null,
is_valide bool not null,
foreign key(email_utilisateur) references utilisateur(email)
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
description varchar(300),
url_image varchar(300) not null,
url_video varchar(100) not null,
horaire date not null
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
nb_places int not null,
nb_places_restantes int not null,
tarif_normal numeric(6,2) not null,
tarif_reduit numeric(6,2) not null,
foreign key(id_lieu) references lieu_spectacle(id)
);';

$spectacles_artistes = 
'create table spectacle_artistes(
id_spectacle uuid ,
id_artiste uuid ,
primary key(id_spectacle,id_artiste),
foreign key(id_artiste) references artiste(id)
);';
$billet = '
create table billet(
id uuid primary key,
email_utilisateur varchar(50) not null,
id_soiree uuid not null,
tarif numeric(6,2) not null,
foreign key(email_utilisateur) references utilisateur(email),
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


/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  24/02/2012 16:03:11                      */
/* Dernier modification : 16/03/2012	                        */
/*==============================================================*/

drop database if exists courcheveldb;

create database courcheveldb;

use courcheveldb;

set names 'utf8';

set character set 'utf8';

drop table if exists courchevel_accreditation;

drop table if exists courchevel_accreditation_zones;

drop table if exists courchevel_categorie;

drop table if exists courchevel_client;

drop table if exists courchevel_evenement;

drop table if exists courchevel_parametres_evenements;

drop table if exists courchevel_pays;

drop table if exists courchevel_utilisateur;

drop table if exists courchevel_zone;

/*==============================================================*/
/* Table : courchevel_accreditation                             */
/*==============================================================*/
create table courchevel_accreditation
(
   idaccreditation      bigint not null auto_increment,
   idclient             bigint not null,
   idcategorie          bigint default -1,
   idevenement          bigint not null,
   referent		        bigint default null,
   etataccreditation    tinyint not null,
   dateaccreditation    bigint not null,
   fonction             text default null,
   groupe				varchar(50) default null,
   allaccess			tinyint not null,
   /* champs en plus pour le presse */
   numeropresse         varchar(200) not null,
   primary key (idaccreditation)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : courchevel_accreditation_zones                       */
/*==============================================================*/
create table courchevel_accreditation_zones
(
   idaccreditation      bigint not null,
   idzone               bigint not null,
   primary key (idaccreditation, idzone)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : courchevel_categorie                                 */
/*==============================================================*/
create table courchevel_categorie
(
   idcategorie          bigint not null auto_increment,
   surcategorie         bigint,
   libellecategorie     varchar(50) not null,
   couleur				varchar(6) default 'FFFFFF',
   primary key (idcategorie)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : courchevel_client                                    */
/*==============================================================*/
create table courchevel_client
(
   idclient             bigint not null auto_increment,
   pays                 varchar(3) not null,
   nom                  varchar(50) not null,
   prenom               varchar(50) not null,
   organisme            varchar(100) default null,
   tel                  varchar(25) default null,
   mail                 text default null,
   /* champs en plus pour le presse */
   adresse              varchar(500),
   primary key (idclient)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : courchevel_evenement                                 */
/*==============================================================*/
create table courchevel_evenement
(
   idevenement          bigint not null auto_increment,
   libelleevenement     text not null,
   descriptionevenement text,
   datedebut            bigint not null,
   datefin              bigint not null,
   listezones           text not null,
   textmail				text default '',
   primary key (idevenement)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : courchevel_parametres_evenements                     */
/*==============================================================*/
create table courchevel_parametres_evenements
(
   idevenement          bigint not null,
   idcategorie          bigint not null,
   idzone               bigint not null,
   codezone				int,
   primary key (idzone, idevenement, idcategorie)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : courchevel_pays                                      */
/*==============================================================*/
create table courchevel_pays
(
   idpays               varchar(3) not null,
   nompays              text not null,
   indicatiftel         varchar(10) not null,
   primary key (idpays)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : courchevel_utilisateur                               */
/*==============================================================*/
create table courchevel_utilisateur
(
   idutilisateur        bigint not null auto_increment,
   login                varchar(50) not null,
   mdp                  varchar(50) not null,
   primary key (idutilisateur)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : courchevel_zone                                      */
/*==============================================================*/
create table courchevel_zone
(
   idzone               bigint not null auto_increment,
   codezone             varchar(5) not null,
   libellezone          text not null,
   primary key (idzone)
) engine = InnoDB, charset = utf8;

insert into courchevel_utilisateur (login,mdp) values ('root', 'root');
insert into courchevel_utilisateur (login,mdp) values ('club', 'club@sport73');

insert into courchevel_client (pays,nom,prenom,organisme,tel,mail) values ('CHE','ASSIER','Aymeric','World Company','0123456789','aymeric.assier@gmail.com');
insert into courchevel_client (pays,nom,prenom,organisme,tel,mail,adresse) values ('FRA','LOMBARD','Adrien','World Company','0234567891','adrien.lombard@gmail.com','8 Rue Isaline 73100 Aix Les Bains');
insert into courchevel_client (pays,nom,prenom,tel,mail) values ('BEL','ARNOULD','Mickaël','0345678912','mickael.arnould@gmail.com');
insert into courchevel_client (pays,nom,prenom,tel,mail) values ('FRA','FRANCHON','Sebastien','0456789123','seb.franchon@gmail.com');
insert into courchevel_client (pays,nom,prenom,tel,mail) values ('TUN','CHRIGUI','Hajer','0567891234','hajer.chrigui@gmail.com');

insert into courchevel_zone (libellezone) values ('Data / Timing');
insert into courchevel_zone (libellezone) values ('Team Areas');
insert into courchevel_zone (libellezone) values ('Coach Areas');
insert into courchevel_zone (libellezone) values ('Sports Areas');
insert into courchevel_zone (libellezone) values ('Start & Warm Up');
insert into courchevel_zone (libellezone) values ('Officials Areas');
insert into courchevel_zone (libellezone) values ('TV / Radio Areas');
insert into courchevel_zone (libellezone) values ('TV / Radio Commentators');
insert into courchevel_zone (libellezone) values ('IBC / TV Compound');
insert into courchevel_zone (libellezone) values ('Media Areas');
insert into courchevel_zone (libellezone) values ('Photographer Areas');
insert into courchevel_zone (libellezone) values ('Special Media Areas');
insert into courchevel_zone (libellezone) values ('Press Centre');
insert into courchevel_zone (libellezone) values ('VIP');
insert into courchevel_zone (libellezone) values ('O.C. Areas');

insert into courchevel_evenement (libelleevenement,datedebut,datefin) values ('Coupe du monde feminine de ski alpin hiver 2011','1324076400','1324162800');
insert into courchevel_evenement (libelleevenement,datedebut,datefin) values ('Coupe du monde d''été de saut a ski 2011','1313013600','1313100000');
insert into courchevel_evenement (libelleevenement,datedebut,datefin) values ('Coupe du monde feminine de ski alpin hiver 2012','1355612400','1355698800');

insert into courchevel_categorie (libellecategorie, couleur) values ('Presse', 'FF0000');
insert into courchevel_categorie (surcategorie,libellecategorie, couleur) values (1,'Presse orale', 'FF0000');
insert into courchevel_categorie (surcategorie,libellecategorie, couleur) values (1,'Presse écrite', 'FF0000');
insert into courchevel_categorie (surcategorie,libellecategorie, couleur) values (2,'Presse TV', 'FF0000');
insert into courchevel_categorie (surcategorie,libellecategorie, couleur) values (2,'Presse radio', 'FF0000');
insert into courchevel_categorie (libellecategorie, couleur) values ('Bénévole', '008B8B');
insert into courchevel_categorie (surcategorie, libellecategorie, couleur) values (6, 'Serveur restaurant', '008B8B');
insert into courchevel_categorie (surcategorie, libellecategorie, couleur) values (6, 'Conducteur navette', '008B8B');
insert into courchevel_categorie (surcategorie, libellecategorie, couleur) values (6, 'Responsable parkings', '008B8B');
insert into courchevel_categorie (surcategorie, libellecategorie, couleur) values (9, 'Responsable parking altiport', '008B8B');
insert into courchevel_categorie (surcategorie, libellecategorie, couleur) values (9, 'Responsable parking stade', '008B8B');
insert into courchevel_categorie (libellecategorie, couleur) values ('Sportif', 'F4A460');
insert into courchevel_categorie (libellecategorie, couleur) values ('VIP', '9ACD32');

insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 4, 7, 06);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 4, 8, 07);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 4, 9, 08);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 4, 10, 09);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 7, 14, 13);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 7, 15, 14);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 12, 2, 01);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 12, 3, 02);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 12, 4, 03);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 12, 5, 04);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (1, 13, 14, 13);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 1, 7, 06);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 1, 8, 07);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 1, 9, 08);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 1, 10, 09);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 1, 11, 10);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 1, 12, 11);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 6, 6, 05);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 6, 14, 13);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (2, 13, 14, 13);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 4, 7, 06);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 4, 8, 07);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 4, 9, 08);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 4, 10, 09);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 4, 12, 11);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 7, 14, 13);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 12, 2, 01);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 12, 3, 02);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 12, 4, 03);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 12, 5, 04);
insert into courchevel_parametres_evenements (idevenement, idcategorie, idzone, codezone) values (3, 13, 14, 13);

insert into courchevel_accreditation (idclient, idcategorie, idevenement, etataccreditation, dateaccreditation) values (1, 13, 1, '0', '1324076400');
insert into courchevel_accreditation (idclient, idcategorie, idevenement, etataccreditation, dateaccreditation) values (1, 13, 2, '0', '1330038000');
insert into courchevel_accreditation (idclient, idcategorie, idevenement, etataccreditation, dateaccreditation) values (1, 13, 3, '1', '1330297200');
insert into courchevel_accreditation (idclient, idcategorie, idevenement, etataccreditation, dateaccreditation) values (3, 12, 1, '0', '1324076400');
insert into courchevel_accreditation (idclient, idcategorie, idevenement, etataccreditation, dateaccreditation) values (3, 12, 3, '0', '1330038000');
insert into courchevel_accreditation (idclient, idcategorie, idevenement, etataccreditation, dateaccreditation, numeropresse) values (2, 4, 3, '1', '1330038000', '2592825830');

insert into courchevel_accreditation_zones (idaccreditation, idzone) values (1, 14);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (2, 14);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (3, 14);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (4, 2);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (4, 3);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (4, 4);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (4, 5);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (5, 2);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (5, 3);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (5, 4);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (5, 5);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (6, 7);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (5, 8);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (5, 9);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (5, 10);
insert into courchevel_accreditation_zones (idaccreditation, idzone) values (5, 12);

INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('AFG','Afghanistan','93');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ZAF','Afrique du Sud','27');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ALB','Albanie','355');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('DZA','Algérie','213');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('DEU','Allemagne','49');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('AND','Andorre','376');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('AGO','Angola','244');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('AIA','Anguilla','1264');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ATG','Antigua-et-Barbuda','1268');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SAU','Arabie saoudite','966');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ARG','Argentine','54');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ARM','Arménie','374');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ABW','Aruba','297');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('AUS','Australie','61');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('AUT','Autriche','43');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('AZE','Azerbaïdjan','994');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BHS','Bahamas','1242');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BHR','Bahreïn','973');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BGD','Bangladesh','880');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BRB','Barbade','1246');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BEL','Belgique','32');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BLZ','Belize','501');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BEN','Bénin','229');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BMU','Bermudes','1441');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BTN','Bhoutan','975');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BLR','Bielorussie','375');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BOL','Bolivie','591');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BES','Bonaire, Saint-Eustache et Saba','599-7');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BIH','Bosnie-Herzégovine','387');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BWA','Botswana','267');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BRA','Brésil','55');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BRN','Brunei','673');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BGR','Bulgarie','359');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BFA','Burkina Faso','226');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('BDI','Burundi','257');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('KHM','Cambodge','855');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CMR','Cameroun','237');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CAN','Canada','1');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CPV','Cap-Vert','238');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CAF','République centrafricaine','236');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CHL','Chili','56');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CHN','Chine','86');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CYP','Chypre','357');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('COL','Colombie','57');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('COM','Comores','269');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('COG','Congo-Brazzaville','243');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('COD','Congo-Kinshasa','242');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PRK','Corée du Nord','850');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('KOR','Corée du Sud','82');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CRI','Costa Rica','506');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CIV','Côte d’Ivoire','225');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('HRV','Croatie','385');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CUB','Cuba','53');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CUW','Curaçao','599-9');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('DNK','Danemark','45');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('DJI','Djibouti','253');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('DMA','Dominique','1767');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('EGY','Egypte','20');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SLV','El Salvador','503');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ARE','Emirats arabes unis','971');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ECU','Equateur','593');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ERI','Erythrée','291');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ESP','Espagne','34');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('EST','Estonie','372');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('USA','Etats-Unis','1');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ETH','Ethiopie','251');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('FIN','Finlande','358');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('FRA','France','33');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GAB','Gabon','241');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GMB','Gambie','220');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GEO','Géorgie','995');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GHA','Ghana','233');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GIB','Gibraltar','350');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GRC','Grèce','30');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GRD','Grenade','1473');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GRL','Groenland','299');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GLP','Guadeloupe','590');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GTM','Guatemala','502');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GGY','Guernesey','441 481');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GIN','Guinée','224');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GNB','Guinée-Bissau','245');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GNQ','Guinée équatoriale','240');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GUY','Guyana','592');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GUF','Guyane française','594');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('HTI','Haïti','509');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('HND','Honduras','504');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('HKG','Hong Kong','852');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('HUN','Hongrie','36');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MUS','Ile Maurice','230');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('FJI','Iles Fidji','679');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MNP','Iles Mariannes du Nord','1670');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MHL','Iles Marshall','692');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SLB','Iles Salomon','677');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('VGB','Iles Vierges britanniques','1284');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('VIR','Iles Vierges des États-Unis','1340');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('IND','Inde','91');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('IDN','Indonésie','62');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('IRQ','Irak','964');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('IRN','Iran','98');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('IRL','Irlande','353');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ISL','Islande','354');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ISR','Israël','972');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ITA','Italie','39');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('JAM','Jamaïque','1876');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('JPN','Japon','81');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('JEY','Jersey','441 534');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('JOR','Jordanie','962');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('KAZ','Kazakhstan','7');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('KEN','Kenya','254');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('KGZ','Kirghizistan','996');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('KIR','Kiribati','686');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('XKO','Kosovo','381');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('KWT','Koweït','965');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LAO','Laos','856');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LSO','Lesotho','266');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LVA','Lettonie','371');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LBN','Liban','961');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LBR','Libéria','231');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LBY','Libye','218');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LIE','Liechtenstein','423');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LTU','Lituanie','370');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LUX','Luxembourg','352');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MAC','Macao','853');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MKD','Macédoine','389');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MDG','Madagascar','261');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MYS','Malaisie','60');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MWI','Malawi','265');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MDV','Maldives','960');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MLI','Mali','223');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MLT','Malte','356');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MAR','Maroc','212');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MTQ','Martinique','596');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MRT','Mauritanie','222');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MYT','Mayotte','269');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MEX','Mexique','52');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MDA','Moldavie','373');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('FSM','Etats fédérés de Micronesie','691');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MCO','Monaco','377');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MNG','Mongolie','976');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MNE','Monténégro','382');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MSR','Montserrat','1664');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MOZ','Mozambique','258');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MMR','Myanmar','95');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NAM','Namibie','264');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NRU','Nauru','674');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NPL','Népal','977');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NIC','Nicaragua','505');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NER','Niger','227');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NGA','Nigéria','234');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NOR','Norvège','47');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NCL','Nouvelle-Calédonie','687');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NZL','Nouvelle-Zélande','64');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('OMN','Oman','968');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('UGA','Ouganda','256');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('UZB','Ouzbékistan','998');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PAK','Pakistan','92');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PLW','Palau','680');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PSE','Palestine','970');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PAN','Panama','507');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PNG','Papouasie-Nouvelle-Guinée','675');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PRY','Paraguay','595');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('NLD','Pays-Bas','31');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PER','Pérou','51');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PHL','Philippines','63');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('POL','Pologne','48');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PYF','Polynésie française','689');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PRI','Porto Rico','1787');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('PRT','Portugal','351');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('QAT','Qatar','974');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('DOM','République dominicaine','1809');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CZE','République tchèque','420');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('REU','Réunion','262');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ROU','Roumanie','40');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('GBR','Royaume-Uni','44');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('RUS','Russie','7');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('RWA','Rwanda','250');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ESH','Sahara occidental','212');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SMR','Saint-Marin','378');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LCA','Sainte-Lucie','1758');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('KNA','Saint-Kitts-et-Nevis','1');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('MAF','Saint-Martin (partie française)','590');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SXM','Saint-Martin (partie néerlandaise)','599-5');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SPM','Saint-Pierre-et-Miquelon','508');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('VCT','Saint-Vincent-et-les Grenadines','1-784');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('WSM','Samoa','685');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('STP','Sao Tomé-et-Principe','239');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SEN','Sénégal','221');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SRB','Serbie','381');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SYC','Seychelles','248');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SLE','Sierra Leone','232');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SGP','Singapour','65');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SVK','Slovaquie','421');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SVN','Slovénie','386');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SOM','Somalie','252');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SDN','Soudan','249');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SSD','Soudan du Sud','211');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('LKA','Sri Lanka','94');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SWE','Suède','46');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('CHE','Suisse','41');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SUR','Suriname','597');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SJM','Svalbard et Île Jan Mayen','47');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SWZ','Swaziland','268');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('SYR','Syrie','963');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TJK','Tadjikistan','992');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TWN','Taïwan','886');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TZA','Tanzanie','255');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TCD','Tchad','235');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('THA','Thaïlande','66');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TGO','Togo','228');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TON','Tonga','676');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TTO','Trinité-et-Tobago','1868');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TUN','Tunisie','216');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TKM','Turkménistan','993');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TUR','Turquie','90');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('TUV','Tuvalu','688');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('UKR','Ukraine','380');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('URY','Uruguay','598');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('VUT','Vanuatu','678');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('VEN','Venezuela','58');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('VNM','Viet Nam','84');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('WLF','Wallis-et-Futuna','681');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('YEM','Yémen','967');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ZMB','Zambie','260');
INSERT INTO courchevel_pays (idpays,nompays,indicatiftel) VALUES('ZWE','Zimbabwe','263');
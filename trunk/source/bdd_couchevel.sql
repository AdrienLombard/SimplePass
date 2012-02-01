/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  25/01/2012 09:45:47                      */
/*==============================================================*/

drop database if exists courcheveldb;

create database courcheveldb;

use courcheveldb;

set names 'utf8';

set character set 'utf8';

drop table if exists accreditation;

drop table if exists categorie;

drop table if exists client;

drop table if exists donne_acces;

drop table if exists evenement;

drop table if exists pays;

drop table if exists permet;

drop table if exists possede;

drop table if exists utilisateur;

drop table if exists zone;

/*==============================================================*/
/* Table : accreditation                                        */
/*==============================================================*/
create table accreditation
(
   idaccreditation      bigint not null auto_increment,
   idcategorie          bigint not null,
   idevenement          bigint not null,
   idclient				bigint not null,
   etataccreditation	tinyint not null,
   primary key (idaccreditation)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : categorie                                            */
/*==============================================================*/
create table categorie
(
   idcategorie          bigint not null auto_increment,
   surcategorie         bigint default null,
   libellecategorie     text not null,
   primary key (idcategorie)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : client                                               */
/*==============================================================*/
create table client
(
   idclient             bigint not null auto_increment,
   pays                 varchar(3) not null,
   nom                  varchar(50) not null,
   prenom               varchar(50) not null,
   civilite             varchar(10) not null,
   organisme            varchar(100) not null,
   role                 text not null,
   tel                  varchar(25) not null,
   mail                 text not null,
   urlphoto             text not null,
   primary key (idclient)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : donne_acces                                          */
/*==============================================================*/
create table donne_acces
(
   idcategorie          bigint not null,
   idzone               bigint not null,
   primary key (idcategorie, idzone)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : evenement                                            */
/*==============================================================*/
create table evenement
(
   idevenement          bigint not null auto_increment,
   libelleevenement     text not null,
   descriptionevenement text,
   datedebut            bigint not null,
   datefin              bigint not null,
   primary key (idevenement)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : pays                                                 */
/*==============================================================*/
create table pays
(
   idpays               varchar(3) not null,
   nompays              text not null,
   indicatiftel         varchar(10) not null,
   primary key (idpays)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : permet                                               */
/*==============================================================*/
create table permet
(
   idaccreditation      bigint not null,
   idzone               bigint not null,
   primary key (idaccreditation, idzone)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : possede                                              */
/*==============================================================*/
create table possede
(
   idaccreditation      bigint not null,
   idclient             bigint not null,
   primary key (idaccreditation, idclient)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : utilisateur                                          */
/*==============================================================*/
create table utilisateur
(
   idutilisateur        bigint not null auto_increment,
   login                varchar(50) not null,
   mdp                  varchar(50) not null,
   primary key (idutilisateur)
) engine = InnoDB, charset = utf8;

/*==============================================================*/
/* Table : zone                                                 */
/*==============================================================*/
create table zone
(
   idzone               bigint not null auto_increment,
   libellezone          text not null,
   primary key (idzone)
) engine = InnoDB, charset = utf8;

alter table accreditation add constraint fk_depend foreign key (idcategorie)
      references categorie (idcategorie) on delete restrict on update restrict;

alter table accreditation add constraint fk_valable foreign key (idevenement)
      references evenement (idevenement) on delete restrict on update restrict;

alter table categorie add constraint fk_contient foreign key (surcategorie)
      references categorie (idcategorie);

alter table client add constraint fk_appartient foreign key (pays)
      references pays (idpays) on delete restrict on update restrict;

alter table donne_acces add constraint fk_donne_acces foreign key (idcategorie)
      references categorie (idcategorie) on delete restrict on update restrict;

alter table donne_acces add constraint fk_donne_acces2 foreign key (idzone)
      references zone (idzone) on delete restrict on update restrict;

alter table permet add constraint fk_permet foreign key (idaccreditation)
      references accreditation (idaccreditation) on delete restrict on update restrict;

alter table permet add constraint fk_permet2 foreign key (idzone)
      references zone (idzone) on delete restrict on update restrict;

alter table possede add constraint fk_possede foreign key (idaccreditation)
      references accreditation (idaccreditation) on delete restrict on update restrict;

alter table possede add constraint fk_possede2 foreign key (idclient)
      references client (idclient) on delete restrict on update restrict;

insert into utilisateur (login,mdp) values ('root', 'root');

INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('AFG','Afghanistan','93');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ZAF','Afrique du Sud','27');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ALB','Albanie','355');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('DZA','Algérie','213');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('DEU','Allemagne','49');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('AND','Andorre','376');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('AGO','Angola','244');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('AIA','Anguilla','1264');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ATG','Antigua-et-Barbuda','1268');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SAU','Arabie saoudite','966');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ARG','Argentine','54');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ARM','Arménie','374');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ABW','Aruba','297');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('AUS','Australie','61');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('AUT','Autriche','43');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('AZE','Azerbaïdjan','994');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BHS','Bahamas','1242');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BHR','Bahreïn','973');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BGD','Bangladesh','880');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BRB','Barbade','1246');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BEL','Belgique','32');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BLZ','Belize','501');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BEN','Bénin','229');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BMU','Bermudes','1441');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BTN','Bhoutan','975');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BLR','Bielorussie','375');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BOL','Bolivie','591');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BES','Bonaire, Saint-Eustache et Saba','599-7');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BIH','Bosnie-Herzégovine','387');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BWA','Botswana','267');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BRA','Brésil','55');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BRN','Brunei','673');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BGR','Bulgarie','359');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BFA','Burkina Faso','226');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('BDI','Burundi','257');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('KHM','Cambodge','855');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CMR','Cameroun','237');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CAN','Canada','1');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CPV','Cap-Vert','238');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CAF','République centrafricaine','236');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CHL','Chili','56');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CHN','Chine','86');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CYP','Chypre','357');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('COL','Colombie','57');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('COM','Comores','269');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('COG','Congo-Brazzaville','243');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('COD','Congo-Kinshasa','242');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PRK','Corée du Nord','850');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('KOR','Corée du Sud','82');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CRI','Costa Rica','506');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CIV','Côte d’Ivoire','225');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('HRV','Croatie','385');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CUB','Cuba','53');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CUW','Curaçao','599-9');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('DNK','Danemark','45');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('DJI','Djibouti','253');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('DMA','Dominique','1767');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('EGY','Egypte','20');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SLV','El Salvador','503');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ARE','Emirats arabes unis','971');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ECU','Equateur','593');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ERI','Erythrée','291');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ESP','Espagne','34');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('EST','Estonie','372');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('USA','Etats-Unis','1');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ETH','Ethiopie','251');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('FIN','Finlande','358');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('FRA','France','33');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GAB','Gabon','241');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GMB','Gambie','220');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GEO','Géorgie','995');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GHA','Ghana','233');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GIB','Gibraltar','350');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GRC','Grèce','30');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GRD','Grenade','1473');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GRL','Groenland','299');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GLP','Guadeloupe','590');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GTM','Guatemala','502');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GGY','Guernesey','441 481');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GIN','Guinée','224');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GNB','Guinée-Bissau','245');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GNQ','Guinée équatoriale','240');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GUY','Guyana','592');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GUF','Guyane française','594');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('HTI','Haïti','509');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('HND','Honduras','504');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('HKG','Hong Kong','852');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('HUN','Hongrie','36');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MUS','Ile Maurice','230');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('FJI','Iles Fidji','679');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MNP','les Mariannes du Nord','1670');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MHL','les Marshall','692');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SLB','les Salomon','677');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('VGB','les Vierges britanniques','1284');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('VIR','les Vierges des États-Unis','1340');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('IND','Inde','91');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('IDN','Indonésie','62');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('IRQ','Irak','964');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('IRN','Iran','98');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('IRL','Irlande','353');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ISL','Islande','354');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ISR','Israël','972');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ITA','Italie','39');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('JAM','Jamaïque','1876');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('JPN','Japon','81');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('JEY','Jersey','441 534');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('JOR','Jordanie','962');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('KAZ','Kazakhstan','7');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('KEN','Kenya','254');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('KGZ','Kirghizistan','996');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('KIR','Kiribati','686');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('XKO','Kosovo','381');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('KWT','Koweït','965');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LAO','Laos','856');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LSO','Lesotho','266');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LVA','Lettonie','371');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LBN','Liban','961');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LBR','Libéria','231');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LBY','Libye','218');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LIE','Liechtenstein','423');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LTU','Lituanie','370');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LUX','Luxembourg','352');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MAC','Macao','853');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MKD','Macédoine','389');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MDG','Madagascar','261');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MYS','Malaisie','60');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MWI','Malawi','265');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MDV','Maldives','960');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MLI','Mali','223');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MLT','Malte','356');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MAR','Maroc','212');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MTQ','Martinique','596');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MRT','Mauritanie','222');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MYT','Mayotte','269');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MEX','Mexique','52');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MDA','Moldavie','373');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('FSM','Etats fédérés de Micronesie','691');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MCO','Monaco','377');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MNG','Mongolie','976');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MNE','Monténégro','382');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MSR','Montserrat','1664');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MOZ','Mozambique','258');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MMR','Myanmar','95');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NAM','Namibie','264');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NRU','Nauru','674');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NPL','Népal','977');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NIC','Nicaragua','505');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NER','Niger','227');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NGA','Nigéria','234');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NOR','Norvège','47');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NCL','Nouvelle-Calédonie','687');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NZL','Nouvelle-Zélande','64');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('OMN','Oman','968');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('UGA','Ouganda','256');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('UZB','Ouzbékistan','998');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PAK','Pakistan','92');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PLW','Palau','680');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PSE','Palestine','970');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PAN','Panama','507');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PNG','Papouasie-Nouvelle-Guinée','675');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PRY','Paraguay','595');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('NLD','Pays-Bas','31');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PER','Pérou','51');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PHL','Philippines','63');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('POL','Pologne','48');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PYF','Polynésie française','689');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PRI','Porto Rico','1787');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('PRT','Portugal','351');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('QAT','Qatar','974');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('DOM','République dominicaine','1809');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CZE','République tchèque','420');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('REU','Réunion','262');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ROU','Roumanie','40');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('GBR','Royaume-Uni','44');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('RUS','Russie','7');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('RWA','Rwanda','250');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ESH','Sahara occidental','212');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SMR','Saint-Marin','378');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LCA','Sainte-Lucie','1758');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('KNA','Saint-Kitts-et-Nevis','1');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('MAF','Saint-Martin (partie française)','590');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SXM','Saint-Martin (partie néerlandaise)','599-5');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SPM','Saint-Pierre-et-Miquelon','508');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('VCT','Saint-Vincent-et-les Grenadines','1-784');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('WSM','Samoa','685');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('STP','Sao Tomé-et-Principe','239');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SEN','Sénégal','221');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SRB','Serbie','381');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SYC','Seychelles','248');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SLE','Sierra Leone','232');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SGP','Singapour','65');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SVK','Slovaquie','421');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SVN','Slovénie','386');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SOM','Somalie','252');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SDN','Soudan','249');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SSD','Soudan du Sud','211');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('LKA','Sri Lanka','94');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SWE','Suède','46');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('CHE','Suisse','41');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SUR','Suriname','597');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SJM','Svalbard et Île Jan Mayen','47');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SWZ','Swaziland','268');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('SYR','Syrie','963');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TJK','Tadjikistan','992');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TWN','Taïwan','886');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TZA','Tanzanie','255');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TCD','Tchad','235');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('THA','Thaïlande','66');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TGO','Togo','228');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TON','Tonga','676');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TTO','Trinité-et-Tobago','1868');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TUN','Tunisie','216');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TKM','Turkménistan','993');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TUR','Turquie','90');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('TUV','Tuvalu','688');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('UKR','Ukraine','380');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('URY','Uruguay','598');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('VUT','Vanuatu','678');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('VEN','Venezuela','58');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('VNM','Viet Nam','84');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('WLF','Wallis-et-Futuna','681');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('YEM','Yémen','967');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ZMB','Zambie','260');
INSERT INTO pays (idpays,nompays,indicatiftel) VALUES('ZWE','Zimbabwe','263');

insert into zone (libellezone) values ('Espace presse');
insert into zone (libellezone) values ('Pied de la piste');
insert into zone (libellezone) values ('Salle de spectacle');
insert into zone (libellezone) values ('Tribune officielle');

insert into evenement (libelleevenement,datedebut,datefin) values ('Championnats du monde de saut à ski d''été 2012','1341136800','1343728800');
insert into evenement (libelleevenement,datedebut,datefin) values ('Championnats du monde de slalom 2012','1354359600','1356001200');

insert into categorie (libellecategorie) values ('Presse');
insert into categorie (surcategorie,libellecategorie) values (1,'Presse TV');
insert into categorie (surcategorie,libellecategorie) values (1,'Presse écrite');
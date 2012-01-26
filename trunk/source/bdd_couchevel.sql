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
) engine = InnoDB;

/*==============================================================*/
/* Table : categorie                                            */
/*==============================================================*/
create table categorie
(
   idcategorie          bigint not null auto_increment,
   surcategorie         bigint,
   libellecategorie     text not null,
   primary key (idcategorie)
) engine = InnoDB;

/*==============================================================*/
/* Table : client                                               */
/*==============================================================*/
create table client
(
   idclient             bigint not null auto_increment,
   pays                 bigint not null,
   nom                  varchar(50) not null,
   prenom               varchar(50) not null,
   civilite             varchar(10) not null,
   organisme            varchar(100) not null,
   role                 text not null,
   tel                  varchar(25) not null,
   mail                 text not null,
   urlphoto             text not null,
   primary key (idclient)
) engine = InnoDB;

/*==============================================================*/
/* Table : donne_acces                                          */
/*==============================================================*/
create table donne_acces
(
   idcategorie          bigint not null,
   idzone               bigint not null,
   primary key (idcategorie, idzone)
) engine = InnoDB;

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
) engine = InnoDB;

/*==============================================================*/
/* Table : pays                                                 */
/*==============================================================*/
create table pays
(
   idpays               varchar(3) not null,
   nompays              text not null,
   indicatiftel         varchar(5) not null,
   primary key (idpays)
) engine = InnoDB;

/*==============================================================*/
/* Table : permet                                               */
/*==============================================================*/
create table permet
(
   idaccreditation      bigint not null,
   idzone               bigint not null,
   primary key (idaccreditation, idzone)
) engine = InnoDB;

/*==============================================================*/
/* Table : possede                                              */
/*==============================================================*/
create table possede
(
   idaccreditation      bigint not null,
   idclient             bigint not null,
   primary key (idaccreditation, idclient)
) engine = InnoDB;

/*==============================================================*/
/* Table : utilisateur                                          */
/*==============================================================*/
create table utilisateur
(
   idutilisateur        bigint not null auto_increment,
   login                varchar(50) not null,
   mdp                  varchar(50) not null,
   primary key (idutilisateur)
) engine = InnoDB;

/*==============================================================*/
/* Table : zone                                                 */
/*==============================================================*/
create table zone
(
   idzone               bigint not null auto_increment,
   libellezone          text not null,
   primary key (idzone)
) engine = InnoDB;

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
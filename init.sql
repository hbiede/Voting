drop table if exists ballot_entries;
drop table if exists candidates;
drop table if exists admins;
drop table if exists users;
drop table if exists superadmins;
drop table if exists elections;
drop table if exists organizations;

create table organizations
(
	id               int auto_increment                  primary key,
	organizationName varchar(255)                        not null,
	timeCreated      timestamp default CURRENT_TIMESTAMP not null,
    lastModified     timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint organizations_organizationName_uindex unique (organizationName)
);

create table elections
(
    id               int auto_increment                  primary key,
    electionOpen     int(1)    default 0                 not null,
    voters           int       default 0                 not null,
    organizationID   int                                 not null,
    positionOrder    varchar(255)                        not null,
    timeCreated      timestamp default CURRENT_TIMESTAMP not null,
    lastModified     timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint Elections_Organizations_organizationID_fk foreign key (organizationID) references organizations (id)
);

create table users
(
    id           int auto_increment                  primary key,
    electionID   int                                 not null,
    voterID      varchar(255)                         not null,
    password     varchar(255)                         not null,
    voted        int(1)    default 0                 not null,
    timeCreated  timestamp default CURRENT_TIMESTAMP not null,
    lastModified timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint Users_Elections_electionID_fk foreign key (electionID) references elections (id),
    constraint users_voterID_uindex unique (voterID)
);

create table admins
(
    username          varchar(255) not null,
    password          varchar(255) not null,
    isSuperAdmin      int(1)       default 0 not null,
    organizationID    int,
    constraint admins_username_uindex unique (username),
    constraint Admins_Organizations_organizationID_fk foreign key (organizationID) references organizations (id)
);

create table ballot_entries
(
	id              int auto_increment primary key,
	candidateID     int                not null,
    organizationID  int                not null,
    firstName       varchar(255)       not null,
    lastName        varchar(255)       not null,
    position        varchar(255)       not null,
	electionID      int                not null,
	votes           int                not null default 0,
	constraint candidates_candidateID_electionID_uindex unique (candidateID, electionID),
    constraint Ballot_Entries_Elections_electionID_fk foreign key (electionID) references elections (id)
);

INSERT INTO admins (isSuperAdmin, username, password) VALUE (1, 'admin','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8');


create database gestion_etudiants;
use gestion_etudiants;

create table students (
    id int auto_increment primary key,
    nom varchar(50) not null,
    prenom varchar(50) not null,
    email varchar(100) unique,
    date_naissance date null,
    moyenne decimal(4, 2) default 0.00,
    created_at timestamp default current_timestamp
);


create table courses (
    id int auto_increment primary key,
    titre varchar(100) not null
);

create table grades (
    id int auto_increment primary key,
    student_id int,
    course_id int,
    note decimal(4, 2) not null,
    foreign key (student_id) references students(id) on delete cascade,
    foreign key (course_id) references courses(id) on delete cascade
);

-- =============================================
-- Triggers : Automatisation Totale de la Moyenne
-- =============================================
drop trigger if exists after_grade_insert;
delimiter //

-- Cas 1 : Mise à jour après INSERT
create trigger after_grade_insert
after insert on grades
for each row
begin
    update students 
    set moyenne = (select ifnull(avg(note), 0) from grades where student_id = new.student_id)
    where id = new.student_id;
end //

drop trigger if exists after_grade_update;
-- Cas 2 : Mise à jour après UPDATE (Si on modifie une note)
create trigger after_grade_update
after update on grades
for each row
begin
    update students 
    set moyenne = (select ifnull(avg(note), 0) from grades where student_id = new.student_id)
    where id = new.student_id;
end //

-- Cas 3 : Mise à jour après DELETE (Si on supprime une note)
drop trigger if exists after_grade_delete;
create trigger after_grade_delete
after delete on grades
for each row
begin
    update students 
    set moyenne = (select ifnull(avg(note), 0) from grades where student_id = old.student_id)
    where id = old.student_id;
end //

delimiter ;

-- =============================================
-- 4. Procédures Stockées (Logique Métier)
-- =============================================

-- Ajouter un étudiant
delimiter //
create procedure addstudent(
    in p_nom varchar(50),
    in p_prenom varchar(50),
    in p_email varchar(100),
    in p_date_naissance date
)
begin
    insert into students (nom, prenom, email, date_naissance)
    values (p_nom, p_prenom, p_email, p_date_naissance);
    
end //   
 

-- Ajouter une note avec validation (0-20)
create procedure addgrade(
    in p_student_id int,
    in p_course_id int,
    in p_note decimal(4, 2)
)
begin
    if p_note < 0 or p_note > 20 then
        signal sqlstate '45000'
        set message_text = 'erreur : la note doit être entre 0 et 20.';
    else
        insert into grades (student_id, course_id, note)
        values (p_student_id, p_course_id, p_note);
    end if;
end //
delimiter ;

-- =============================================
-- 5. Données de Test Initiales
-- =============================================

insert into courses (titre) values 
('algorithmique'),
('bases de données'),
('développement web');


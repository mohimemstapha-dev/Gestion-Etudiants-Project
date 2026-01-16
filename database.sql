-- création de la base de données
create database if not exists gestion_etudiants;
use gestion_etudiants;

-- table : students
create table if not exists students (
    id int auto_increment primary key,
    nom varchar(50) not null,
    prenom varchar(50) not null,
    email varchar(100) unique,
    moyenne decimal(4, 2) default 0.00
);

-- table : courses
create table if not exists courses (
    id int auto_increment primary key,
    titre varchar(100) not null
);

-- table : grades
create table if not exists grades (
    id int auto_increment primary key,
    student_id int,
    course_id int,
    note decimal(4, 2) not null,
    foreign key (student_id) references students(id) on delete cascade,
    foreign key (course_id) references courses(id) on delete cascade
);

-- trigger : recalculer la moyenne
delimiter //
create trigger after_grade_insert
after insert on grades
for each row
begin
    declare avg_score decimal(4, 2);

    select avg(note) into avg_score
    from grades
    where student_id = new.student_id;

    update students
    set moyenne = ifnull(avg_score, 0)
    where id = new.student_id;
end //
delimiter ;

-- procédure : ajouter une note avec validation
delimiter //
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

-- données de test
insert into courses (titre) values 
('algorithmique'),
('bases de données'),
('développement web');
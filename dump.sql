--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.1
-- Dumped by pg_dump version 9.6.1

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: hstore; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS hstore WITH SCHEMA public;


--
-- Name: EXTENSION hstore; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION hstore IS 'data type for storing sets of (key, value) pairs';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: academies; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE academies (
    title text NOT NULL,
    country text NOT NULL,
    state text NOT NULL,
    city text NOT NULL,
    contact text NOT NULL,
    address text NOT NULL,
    id integer NOT NULL
);


ALTER TABLE academies OWNER TO postgres;

--
-- Name: academies_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE academies_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE academies_id_seq OWNER TO postgres;

--
-- Name: academies_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE academies_id_seq OWNED BY academies.id;


--
-- Name: academy_coaches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE academy_coaches (
    id integer NOT NULL,
    academy_id integer NOT NULL,
    coach_id integer NOT NULL
);


ALTER TABLE academy_coaches OWNER TO postgres;

--
-- Name: academy_coaches_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE academy_coaches_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE academy_coaches_id_seq OWNER TO postgres;

--
-- Name: academy_coaches_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE academy_coaches_id_seq OWNED BY academy_coaches.id;


--
-- Name: academy_court; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE academy_court (
    id integer NOT NULL,
    academy_id integer NOT NULL,
    court_id integer NOT NULL
);


ALTER TABLE academy_court OWNER TO postgres;

--
-- Name: academy_court_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE academy_court_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE academy_court_id_seq OWNER TO postgres;

--
-- Name: academy_court_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE academy_court_id_seq OWNED BY academy_court.id;


--
-- Name: anonymous_feedback; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE anonymous_feedback (
    id integer NOT NULL,
    user_id integer NOT NULL,
    user_type_id smallint NOT NULL,
    message text,
    date_time timestamp without time zone,
    admin_id smallint NOT NULL
);


ALTER TABLE anonymous_feedback OWNER TO postgres;

--
-- Name: anonymous_feedback_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE anonymous_feedback_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE anonymous_feedback_id_seq OWNER TO postgres;

--
-- Name: anonymous_feedback_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE anonymous_feedback_id_seq OWNED BY anonymous_feedback.id;


--
-- Name: anonymous_feedback_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE anonymous_feedback_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE anonymous_feedback_user_id_seq OWNER TO postgres;

--
-- Name: anonymous_feedback_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE anonymous_feedback_user_id_seq OWNED BY anonymous_feedback.user_id;


--
-- Name: assessments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE assessments (
    id integer NOT NULL,
    match_id integer,
    coach_id integer,
    player_id integer,
    forehand hstore,
    backhand hstore,
    serve hstore,
    return hstore,
    volley hstore,
    positioning hstore,
    strength hstore,
    speed hstore,
    date_time timestamp without time zone,
    power hstore,
    agility hstore,
    smash hstore
);


ALTER TABLE assessments OWNER TO postgres;

--
-- Name: assessment_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE assessment_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE assessment_id_seq OWNER TO postgres;

--
-- Name: assessment_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE assessment_id_seq OWNED BY assessments.id;


--
-- Name: coach_attendance; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE coach_attendance (
    id integer NOT NULL,
    coach_id integer NOT NULL,
    attendance smallint NOT NULL,
    absent_type smallint,
    date_time timestamp without time zone NOT NULL
);


ALTER TABLE coach_attendance OWNER TO postgres;

--
-- Name: coach_attendance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE coach_attendance_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE coach_attendance_id_seq OWNER TO postgres;

--
-- Name: coach_attendance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE coach_attendance_id_seq OWNED BY coach_attendance.id;


--
-- Name: court_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE court_types (
    id integer NOT NULL,
    court_type text NOT NULL
);


ALTER TABLE court_types OWNER TO postgres;

--
-- Name: drill_images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE drill_images (
    drill_id integer NOT NULL,
    drill_image text,
    id integer NOT NULL
);


ALTER TABLE drill_images OWNER TO postgres;

--
-- Name: drill_images_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE drill_images_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE drill_images_id_seq OWNER TO postgres;

--
-- Name: drill_images_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE drill_images_id_seq OWNED BY drill_images.id;


--
-- Name: drill_players; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE drill_players (
    id integer NOT NULL,
    drill_id integer NOT NULL,
    player_id integer NOT NULL,
    event_id integer NOT NULL
);


ALTER TABLE drill_players OWNER TO postgres;

--
-- Name: drill_players_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE drill_players_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE drill_players_id_seq OWNER TO postgres;

--
-- Name: drill_players_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE drill_players_id_seq OWNED BY drill_players.id;


--
-- Name: drills; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE drills (
    name text NOT NULL,
    description text,
    video_file text,
    image_file text,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    id integer NOT NULL
);


ALTER TABLE drills OWNER TO postgres;

--
-- Name: drills_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE drills_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE drills_id_seq OWNER TO postgres;

--
-- Name: drills_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE drills_id_seq OWNED BY drills.id;


--
-- Name: events; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE events (
    id integer NOT NULL,
    title text NOT NULL,
    date_time timestamp without time zone NOT NULL,
    type smallint
);


ALTER TABLE events OWNER TO postgres;

--
-- Name: events_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE events_id_seq OWNER TO postgres;

--
-- Name: events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE events_id_seq OWNED BY events.id;


--
-- Name: player_attendance; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE player_attendance (
    id integer NOT NULL,
    date_time timestamp without time zone NOT NULL,
    player_id integer NOT NULL,
    coach_id integer,
    absent_type smallint,
    attendance smallint NOT NULL
);


ALTER TABLE player_attendance OWNER TO postgres;

--
-- Name: player_attendance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE player_attendance_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE player_attendance_id_seq OWNER TO postgres;

--
-- Name: player_attendance_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE player_attendance_id_seq OWNED BY player_attendance.id;


--
-- Name: players; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE players (
    name text NOT NULL,
    email text NOT NULL,
    contact text NOT NULL,
    address text NOT NULL,
    remark text,
    coachid integer NOT NULL,
    academy_id integer,
    last_login timestamp without time zone,
    last_played timestamp without time zone,
    profile_picture text,
    stanceid smallint NOT NULL,
    id integer NOT NULL,
    user_id integer,
    parent_name text,
    gender smallint,
    dob date
);


ALTER TABLE players OWNER TO postgres;

--
-- Name: players_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE players_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE players_id_seq OWNER TO postgres;

--
-- Name: players_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE players_id_seq OWNED BY players.id;


--
-- Name: scheduling; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE scheduling (
    id integer NOT NULL,
    player1 integer NOT NULL,
    player2 integer NOT NULL,
    academy_id integer NOT NULL,
    court_id smallint NOT NULL,
    date_time timestamp without time zone NOT NULL,
    event_id integer,
    winner_id integer
);


ALTER TABLE scheduling OWNER TO postgres;

--
-- Name: scheduling_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE scheduling_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE scheduling_id_seq OWNER TO postgres;

--
-- Name: scheduling_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE scheduling_id_seq OWNED BY scheduling.id;


--
-- Name: stance; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE stance (
    id smallint NOT NULL,
    stance text NOT NULL
);


ALTER TABLE stance OWNER TO postgres;

--
-- Name: user_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE user_log (
    id integer NOT NULL,
    user_id integer NOT NULL,
    last_login timestamp without time zone,
    last_logout timestamp without time zone
);


ALTER TABLE user_log OWNER TO postgres;

--
-- Name: user_log_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE user_log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE user_log_id_seq OWNER TO postgres;

--
-- Name: user_log_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE user_log_id_seq OWNED BY user_log.id;


--
-- Name: user_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE user_types (
    id smallint NOT NULL,
    type text NOT NULL
);


ALTER TABLE user_types OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE users (
    id integer NOT NULL,
    name text NOT NULL,
    email text NOT NULL,
    password text,
    user_type smallint NOT NULL,
    profile_picture text,
    profile_picture_url text,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    verification_key text,
    verified integer
);


ALTER TABLE users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: academies id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY academies ALTER COLUMN id SET DEFAULT nextval('academies_id_seq'::regclass);


--
-- Name: academy_coaches id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY academy_coaches ALTER COLUMN id SET DEFAULT nextval('academy_coaches_id_seq'::regclass);


--
-- Name: academy_court id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY academy_court ALTER COLUMN id SET DEFAULT nextval('academy_court_id_seq'::regclass);


--
-- Name: anonymous_feedback id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY anonymous_feedback ALTER COLUMN id SET DEFAULT nextval('anonymous_feedback_id_seq'::regclass);


--
-- Name: anonymous_feedback user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY anonymous_feedback ALTER COLUMN user_id SET DEFAULT nextval('anonymous_feedback_user_id_seq'::regclass);


--
-- Name: assessments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY assessments ALTER COLUMN id SET DEFAULT nextval('assessment_id_seq'::regclass);


--
-- Name: coach_attendance id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY coach_attendance ALTER COLUMN id SET DEFAULT nextval('coach_attendance_id_seq'::regclass);


--
-- Name: drill_images id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drill_images ALTER COLUMN id SET DEFAULT nextval('drill_images_id_seq'::regclass);


--
-- Name: drill_players id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drill_players ALTER COLUMN id SET DEFAULT nextval('drill_players_id_seq'::regclass);


--
-- Name: drills id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drills ALTER COLUMN id SET DEFAULT nextval('drills_id_seq'::regclass);


--
-- Name: events id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY events ALTER COLUMN id SET DEFAULT nextval('events_id_seq'::regclass);


--
-- Name: player_attendance id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY player_attendance ALTER COLUMN id SET DEFAULT nextval('player_attendance_id_seq'::regclass);


--
-- Name: players id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players ALTER COLUMN id SET DEFAULT nextval('players_id_seq'::regclass);


--
-- Name: scheduling id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY scheduling ALTER COLUMN id SET DEFAULT nextval('scheduling_id_seq'::regclass);


--
-- Name: user_log id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_log ALTER COLUMN id SET DEFAULT nextval('user_log_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Data for Name: academies; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO academies VALUES ('Okuneva, Prosacco and Frami', 'Cook Islands', 'Minnesota', 'North Abbey', '+1-572-709-2453', '932 Schaefer Highway Apt. 657

South Justuschester, VA 23981-7969', 75);
INSERT INTO academies VALUES ('Hilpert, Lowe and Mayert', 'Pakistan', 'Mississippi', 'Isobelshire', '(807) 846-8399 x2978', '657 Esta Greens Suite 337

North Friedabury, DE 21707-2920', 77);
INSERT INTO academies VALUES ('Hauck-Dietrich', 'Grenada', 'Mississippi', 'New Lilly', '+1.890.413.3088', '919 Gracie Branch

Frederiqueside, MT 01746-9056', 78);
INSERT INTO academies VALUES ('Hackett, Adams and Turner', 'Bahamas', 'Washington', 'North Evertberg', '+18933821629', '4845 Nicolas Key

Port Oraltown, LA 90685-7551', 69);
INSERT INTO academies VALUES ('Graham, Ledner and Olson', 'Svalbard & Jan Mayen Islands', 'Delaware', 'Rudolphshire', '+1-519-500-5996', '23142 Veum Shore

Ahmedfurt, KY 23056-4606', 70);
INSERT INTO academies VALUES ('Conn, Hilll and Gorczany', 'qw', 'Rhode Island', 'Hyattton', '31231', '78029 Elliott Mission Apt. 548

Klockohaven, AK 57085', 71);
INSERT INTO academies VALUES ('Founder1', 'Test', 'Test', 'Test', '09876', 'Test', 88);
INSERT INTO academies VALUES ('Stroman-Nienow', 'Lao People''s Democratic Republic', 'Wyoming', 'New Hillarychester', '090909', '9907 Theron Plains Apt. 618

West Makayla, ID 53373-7331', 76);
INSERT INTO academies VALUES ('Nitzsche Group', 'Andorra', 'Massachusetts', 'Fredrickmouth', '12345', '49340 Medhurst Fort

New Lois, SC 12302', 73);
INSERT INTO academies VALUES ('DEMODEMO', 'India', 'MH', 'MUMBAI', '2343242', 'DSFGF', 99);


--
-- Name: academies_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('academies_id_seq', 99, true);


--
-- Data for Name: academy_coaches; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO academy_coaches VALUES (5, 69, 163);
INSERT INTO academy_coaches VALUES (6, 69, 165);
INSERT INTO academy_coaches VALUES (7, 70, 163);
INSERT INTO academy_coaches VALUES (8, 70, 165);
INSERT INTO academy_coaches VALUES (10, 75, 204);
INSERT INTO academy_coaches VALUES (11, 75, 163);
INSERT INTO academy_coaches VALUES (15, 73, 163);
INSERT INTO academy_coaches VALUES (17, 77, 204);
INSERT INTO academy_coaches VALUES (19, 78, 163);
INSERT INTO academy_coaches VALUES (27, 77, 163);
INSERT INTO academy_coaches VALUES (29, 99, 252);
INSERT INTO academy_coaches VALUES (30, 75, 169);
INSERT INTO academy_coaches VALUES (31, 75, 168);


--
-- Name: academy_coaches_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('academy_coaches_id_seq', 31, true);


--
-- Data for Name: academy_court; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO academy_court VALUES (100, 81, 1);
INSERT INTO academy_court VALUES (101, 81, 2);
INSERT INTO academy_court VALUES (102, 81, 3);
INSERT INTO academy_court VALUES (103, 82, 1);
INSERT INTO academy_court VALUES (104, 82, 2);
INSERT INTO academy_court VALUES (105, 82, 3);
INSERT INTO academy_court VALUES (106, 69, 1);
INSERT INTO academy_court VALUES (107, 69, 2);
INSERT INTO academy_court VALUES (108, 69, 3);
INSERT INTO academy_court VALUES (109, 70, 1);
INSERT INTO academy_court VALUES (110, 70, 2);
INSERT INTO academy_court VALUES (111, 70, 3);
INSERT INTO academy_court VALUES (112, 83, 2);
INSERT INTO academy_court VALUES (81, 75, 1);
INSERT INTO academy_court VALUES (82, 75, 2);
INSERT INTO academy_court VALUES (83, 75, 3);
INSERT INTO academy_court VALUES (84, 75, 4);
INSERT INTO academy_court VALUES (89, 77, 1);
INSERT INTO academy_court VALUES (90, 77, 2);
INSERT INTO academy_court VALUES (91, 77, 3);
INSERT INTO academy_court VALUES (92, 77, 4);
INSERT INTO academy_court VALUES (93, 78, 1);
INSERT INTO academy_court VALUES (94, 78, 2);
INSERT INTO academy_court VALUES (95, 78, 3);
INSERT INTO academy_court VALUES (96, 78, 4);
INSERT INTO academy_court VALUES (119, 84, 1);
INSERT INTO academy_court VALUES (120, 84, 2);
INSERT INTO academy_court VALUES (121, 84, 3);
INSERT INTO academy_court VALUES (122, 84, 4);
INSERT INTO academy_court VALUES (123, 85, 2);
INSERT INTO academy_court VALUES (124, 85, 4);
INSERT INTO academy_court VALUES (125, 86, 1);
INSERT INTO academy_court VALUES (126, 86, 4);
INSERT INTO academy_court VALUES (127, 87, 1);
INSERT INTO academy_court VALUES (128, 87, 4);
INSERT INTO academy_court VALUES (129, 88, 1);
INSERT INTO academy_court VALUES (130, 90, 1);
INSERT INTO academy_court VALUES (131, 76, 1);
INSERT INTO academy_court VALUES (132, 76, 2);
INSERT INTO academy_court VALUES (133, 76, 3);
INSERT INTO academy_court VALUES (134, 76, 4);
INSERT INTO academy_court VALUES (135, 72, 1);
INSERT INTO academy_court VALUES (136, 72, 2);
INSERT INTO academy_court VALUES (137, 72, 3);
INSERT INTO academy_court VALUES (138, 72, 4);
INSERT INTO academy_court VALUES (139, 91, 1);
INSERT INTO academy_court VALUES (140, 73, 1);
INSERT INTO academy_court VALUES (141, 73, 2);
INSERT INTO academy_court VALUES (142, 73, 3);
INSERT INTO academy_court VALUES (143, 73, 4);
INSERT INTO academy_court VALUES (144, 74, 1);
INSERT INTO academy_court VALUES (145, 74, 2);
INSERT INTO academy_court VALUES (146, 74, 3);
INSERT INTO academy_court VALUES (149, 98, 2);
INSERT INTO academy_court VALUES (150, 98, 4);
INSERT INTO academy_court VALUES (151, 99, 3);


--
-- Name: academy_court_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('academy_court_id_seq', 151, true);


--
-- Data for Name: anonymous_feedback; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO anonymous_feedback VALUES (18, 276, 3, 'zcz', '2016-08-10 09:01:39', 175);
INSERT INTO anonymous_feedback VALUES (19, 252, 1, 'Test', '2020-02-07 14:14:59', 175);


--
-- Name: anonymous_feedback_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('anonymous_feedback_id_seq', 19, true);


--
-- Name: anonymous_feedback_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('anonymous_feedback_user_id_seq', 1, false);


--
-- Name: assessment_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('assessment_id_seq', 62, true);


--
-- Data for Name: assessments; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO assessments VALUES (47, 22, 168, 276, '"rating"=>"3", "review"=>"Forehand"', '"rating"=>"3", "review"=>"Backhand"', '"rating"=>"4", "review"=>"Serve"', '"rating"=>"3", "review"=>"Return"', '"rating"=>"3", "review"=>"Volley"', '"rating"=>"4", "review"=>"Positioning"', '"rating"=>"4", "review"=>"Strength"', '"rating"=>"2", "review"=>"Speed"', '2016-08-09 06:12:34', '"rating"=>"2", "review"=>"Speed"', '"rating"=>"2", "review"=>"Speed"', NULL);
INSERT INTO assessments VALUES (48, 27, 171, 271, '"rating"=>"2", "review"=>"a"', '"rating"=>"3", "review"=>"aaa"', '"rating"=>"4", "review"=>"aaaaaaa"', '"rating"=>"5", "review"=>"aaaaaaaaa"', '"rating"=>"1", "review"=>"aaaaaaaaaaaaa"', '"rating"=>"2", "review"=>"aaaaaaaaaaaaaaaa"', NULL, NULL, '2016-08-10 06:06:38', NULL, NULL, NULL);
INSERT INTO assessments VALUES (58, 28, 161, 272, '"rating"=>"3", "review"=>"sdf"', '"rating"=>"4", "review"=>"sdf"', '"rating"=>"5", "review"=>"sdf"', '"rating"=>"4", "review"=>"dsf"', '"rating"=>"3", "review"=>"dsf"', '"rating"=>"2", "review"=>"sdf"', NULL, NULL, '2016-08-13 09:37:36', NULL, NULL, '"rating"=>"1", "review"=>"dsf"');
INSERT INTO assessments VALUES (46, 24, 161, 272, '"rating"=>"5", "review"=>"cc"', '"rating"=>"4", "review"=>"ccc"', '"rating"=>"3", "review"=>"cccc"', '"rating"=>"2", "review"=>"ccccc"', '"rating"=>"1", "review"=>"cccccc"', '"rating"=>"2", "review"=>"ccccccc"', NULL, NULL, '2016-08-08 06:02:10', NULL, NULL, '"rating"=>"3", "review"=>"zxcc"');
INSERT INTO assessments VALUES (51, 26, 161, 272, '"rating"=>"1", "review"=>"faf"', '"rating"=>"5", "review"=>"asfa"', '"rating"=>"4", "review"=>"asfa"', '"rating"=>"3", "review"=>"assaf"', '"rating"=>"2", "review"=>"asfasf"', '"rating"=>"1", "review"=>"asfasf"', '"rating"=>"", "review"=>"asdasd"', '"rating"=>"2", "review"=>"s"', '2016-08-11 11:50:13', '"rating"=>"2", "review"=>"p"', '"rating"=>"5", "review"=>"a"', '"rating"=>"2", "review"=>"xxvg"');
INSERT INTO assessments VALUES (59, 30, 172, 275, '"rating"=>"5", "review"=>"rwwerw"', '"rating"=>"3", "review"=>"wrerw"', '"rating"=>"4", "review"=>"werr"', '"rating"=>"2", "review"=>"rewwer"', '"rating"=>"2", "review"=>"erwr"', '"rating"=>"3", "review"=>"rewr"', NULL, NULL, '2019-01-16 12:58:02', NULL, NULL, '"rating"=>"4", "review"=>"werew"');
INSERT INTO assessments VALUES (60, 39, 204, 292, '"rating"=>"3", "review"=>""', '"rating"=>"2", "review"=>""', '"rating"=>"5", "review"=>""', '"rating"=>"4", "review"=>""', '"rating"=>"2", "review"=>""', '"rating"=>"4", "review"=>""', '"rating"=>"", "review"=>""', '"rating"=>"2", "review"=>""', '2020-02-06 10:34:48', '"rating"=>"5", "review"=>""', '"rating"=>"4", "review"=>""', '"rating"=>"3", "review"=>""');
INSERT INTO assessments VALUES (61, 41, 171, 289, '"rating"=>"3", "review"=>""', '"rating"=>"3", "review"=>""', '"rating"=>"3", "review"=>""', '"rating"=>"3", "review"=>""', '"rating"=>"3", "review"=>""', '"rating"=>"3", "review"=>""', NULL, NULL, '2020-02-07 06:11:17', NULL, NULL, '"rating"=>"3", "review"=>""');
INSERT INTO assessments VALUES (62, 48, 169, 317, '"rating"=>"3", "review"=>""', '"rating"=>"5", "review"=>""', '"rating"=>"5", "review"=>""', '"rating"=>"3", "review"=>""', '"rating"=>"4", "review"=>""', '"rating"=>"4", "review"=>""', NULL, NULL, '2020-02-07 10:26:17', NULL, NULL, '"rating"=>"4", "review"=>""');


--
-- Data for Name: coach_attendance; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO coach_attendance VALUES (44, 204, 1, NULL, '2016-08-10 00:00:00');
INSERT INTO coach_attendance VALUES (46, 204, 1, NULL, '2019-01-09 00:00:00');
INSERT INTO coach_attendance VALUES (47, 204, 1, NULL, '2019-01-16 00:00:00');
INSERT INTO coach_attendance VALUES (49, 165, 0, 1, '2019-01-16 00:00:00');
INSERT INTO coach_attendance VALUES (51, 165, 0, 1, '2019-01-16 12:00:00');
INSERT INTO coach_attendance VALUES (48, 204, 0, 0, '2019-01-16 13:00:00');
INSERT INTO coach_attendance VALUES (56, 252, 1, NULL, '2020-02-07 00:00:00');
INSERT INTO coach_attendance VALUES (57, 252, 0, 0, '2020-02-06 00:00:00');


--
-- Name: coach_attendance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('coach_attendance_id_seq', 57, true);


--
-- Data for Name: court_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO court_types VALUES (1, 'grass');
INSERT INTO court_types VALUES (2, 'clay');
INSERT INTO court_types VALUES (3, 'hard');
INSERT INTO court_types VALUES (4, 'carpet');


--
-- Data for Name: drill_images; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO drill_images VALUES (1, 'image_11474262483.png', 22);
INSERT INTO drill_images VALUES (2, 'image_01547644454.png', 25);
INSERT INTO drill_images VALUES (7, 'image_01580992856.jpg', 26);
INSERT INTO drill_images VALUES (7, 'image_01580992945.jpg', 28);


--
-- Name: drill_images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('drill_images_id_seq', 28, true);


--
-- Data for Name: drill_players; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO drill_players VALUES (11, 5, 270, 35);
INSERT INTO drill_players VALUES (12, 5, 276, 36);
INSERT INTO drill_players VALUES (25, 4, 317, 68);
INSERT INTO drill_players VALUES (26, 6, 317, 74);


--
-- Name: drill_players_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('drill_players_id_seq', 26, true);


--
-- Data for Name: drills; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO drills VALUES ('test drill', 'test', NULL, NULL, '2020-02-06 06:27:36', '2020-02-06 06:27:36', 5);
INSERT INTO drills VALUES ('Test', 'Test 1', NULL, NULL, '2020-02-06 07:19:12', '2020-02-06 07:19:12', 6);
INSERT INTO drills VALUES ('DEMO_DRILL', 'DRILL', 'video_1547644413.mp4', NULL, '2019-01-16 13:13:33', '2020-02-07 13:27:59', 4);


--
-- Name: drills_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('drills_id_seq', 7, true);


--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO events VALUES (13, 'Dr. Gertrude Leannon Vs Maudie Armstrong', '2016-08-04 11:08:00', 0);
INSERT INTO events VALUES (14, 'Lorena Anderson Sr. Vs Chaya Lowe', '2016-07-28 19:00:00', 0);
INSERT INTO events VALUES (15, 'Lorena Anderson Sr.-Player Drill', '2016-08-02 08:10:00', 1);
INSERT INTO events VALUES (16, 'Vernon Morar-Player Drill', '2016-08-24 06:56:00', 1);
INSERT INTO events VALUES (17, 'Vernon Morar Vs Chaya Lowe', '2016-08-18 11:47:00', 0);
INSERT INTO events VALUES (18, 'Vernon Morar-Player Drill', '2016-08-25 00:00:00', 1);
INSERT INTO events VALUES (22, 'Vernon Morar Vs Chaya Lowe', '2016-08-24 06:00:00', 0);
INSERT INTO events VALUES (20, 'Vernon Morar Vs Chaya Lowe', '2016-08-10 18:00:00', 0);
INSERT INTO events VALUES (19, 'zxc Vs Mr. Forest Durgan', '2016-09-06 00:00:00', 0);
INSERT INTO events VALUES (23, 'Vernon Morar Vs Dr. Gertrude Leannon', '2019-01-09 00:00:00', 0);
INSERT INTO events VALUES (24, 'Vernon Morar Vs Maudie Armstrong', '2019-01-24 00:00:00', 0);
INSERT INTO events VALUES (25, 'Lorena Anderson Sr. Vs Dr. Gertrude Leannon', '2019-01-16 00:00:00', 0);
INSERT INTO events VALUES (26, 'Lorena Anderson Sr. Vs Maudie Armstrong', '2019-02-07 00:00:00', 0);
INSERT INTO events VALUES (27, 'Vernon Morar Vs Lorena Anderson Sr.', '2020-02-05 17:00:00', 0);
INSERT INTO events VALUES (28, 'Mr. Forest Durgan-fgf', '2020-06-02 16:44:00', 1);
INSERT INTO events VALUES (29, 'Mr. Forest Durgan-2313', '2020-06-02 16:44:00', 1);
INSERT INTO events VALUES (30, 'Mr. Forest Durgan-test drill', '2020-09-02 17:00:00', 1);
INSERT INTO events VALUES (31, 'Amrit Rathi Vs Prof. Adrian D''Amore DVM', '2020-02-13 09:00:00', 0);
INSERT INTO events VALUES (32, 'Mr. Forest Durgan-test drill', '2020-09-02 17:00:00', 1);
INSERT INTO events VALUES (33, 'Mr. Forest Durgan-test drill', '2020-09-02 17:00:00', 1);
INSERT INTO events VALUES (34, 'Mr. Forest Durgan-test drill', '2020-09-02 17:00:00', 1);
INSERT INTO events VALUES (35, 'Mr. Forest Durgan-test drill', '2020-09-02 17:00:00', 1);
INSERT INTO events VALUES (36, 'Dr. Gertrude Leannon-test drill', '2020-07-02 09:00:00', 1);
INSERT INTO events VALUES (38, 'Vernon Morar-fgf', '2020-04-02 00:00:00', 1);
INSERT INTO events VALUES (39, 'Vernon Morar-dfs', '2020-07-02 00:00:00', 1);
INSERT INTO events VALUES (40, 'Amrit Rathi-dfs', '2020-06-02 00:00:00', 1);
INSERT INTO events VALUES (41, 'Vernon Morar-dfs', '2020-03-02 15:00:00', 1);
INSERT INTO events VALUES (42, 'Vernon Morar Vs demo player', '2020-02-03 00:00:00', 0);
INSERT INTO events VALUES (43, 'Vernon Morar Vs Lorena Anderson Sr.', '2020-02-12 22:00:00', 0);
INSERT INTO events VALUES (21, 'Prof. Adrian D''Amore DVM Vs Lorena Anderson Sr.', '2020-02-13 10:00:00', 0);
INSERT INTO events VALUES (44, 'Lorena Anderson Sr. Vs Chaya Lowe', '2020-02-12 09:00:00', 0);
INSERT INTO events VALUES (37, 'Amrit Rathi Vs Chaya Lowe', '2020-02-13 09:00:00', 0);
INSERT INTO events VALUES (45, 'Chaya Lowe-dfs', '2020-04-02 13:00:00', 1);
INSERT INTO events VALUES (46, 'Chaya Lowe-fgf', '2020-07-02 00:00:00', 1);
INSERT INTO events VALUES (47, 'rt1 Vs Vernon Morar', '2020-02-13 00:00:00', 0);
INSERT INTO events VALUES (48, 'rt1 Vs Chaya Lowe', '2020-02-13 05:00:00', 0);
INSERT INTO events VALUES (49, 'Prof. Adrian D''Amore DVM-test drill', '2020-02-22 12:00:00', 1);
INSERT INTO events VALUES (50, 'Prof. Adrian D''Amore DVM-test drill', '2020-02-14 15:00:00', 1);
INSERT INTO events VALUES (51, 'Vernon Morar-dfs', '2020-02-07 00:00:00', 1);
INSERT INTO events VALUES (52, 'Vernon Morar-fgf', '2020-02-13 12:00:00', 1);
INSERT INTO events VALUES (53, 'demo player Vs Vernon Morar', '2020-02-27 00:00:00', 0);
INSERT INTO events VALUES (54, 'demo player-fgf', '2020-02-15 00:00:00', 1);
INSERT INTO events VALUES (55, 'Maudie Armstrong Vs Amrit Rathi', '2020-02-25 00:00:00', 0);
INSERT INTO events VALUES (56, 'test3 Vs Dr. Gertrude Leannon', '2020-02-18 00:00:00', 0);
INSERT INTO events VALUES (57, 'test3 Vs Dr. Gertrude Leannon', '2020-02-18 00:00:00', 0);
INSERT INTO events VALUES (58, 'test3 Vs demo0', '2020-02-17 00:00:00', 0);
INSERT INTO events VALUES (59, 'Dr. Gertrude Leannon Vs demo0', '2020-02-17 00:00:00', 0);
INSERT INTO events VALUES (60, 'd1 Vs Maudie Armstrong', '2020-02-25 00:00:00', 0);
INSERT INTO events VALUES (61, 'd1 Vs Dummy-Player', '2020-02-12 00:00:00', 0);
INSERT INTO events VALUES (62, 'Dummy-Player Vs d1', '2020-02-08 00:00:00', 0);
INSERT INTO events VALUES (63, 'd1 Vs Dummy-Player', '2020-02-05 00:00:00', 0);
INSERT INTO events VALUES (64, 'd1 Vs Dummy-Player', '2020-02-08 00:00:00', 0);
INSERT INTO events VALUES (65, 'd1 Vs Dummy-Player', '2020-01-31 00:00:00', 0);
INSERT INTO events VALUES (66, 'd1 Vs abc', '2020-01-29 00:00:00', 0);
INSERT INTO events VALUES (67, 'd1-Citrusleaf', '2020-02-03 00:00:00', 1);
INSERT INTO events VALUES (68, 'Dummy-Player-2313', '2020-02-08 00:00:00', 1);
INSERT INTO events VALUES (69, 'Dummy-Player Vs d1', '2020-02-08 00:00:00', 0);
INSERT INTO events VALUES (70, 'Dummy-Player Vs abc', '2020-02-09 00:00:00', 0);
INSERT INTO events VALUES (71, 'Dummy-Player Vs Maudie Armstrong', '2020-02-06 00:00:00', 0);
INSERT INTO events VALUES (72, 'Dummy-Player Vs d1', '2020-02-06 00:00:00', 0);
INSERT INTO events VALUES (73, 'Dummy-Player Vs DUMY', '2020-03-02 00:00:00', 0);
INSERT INTO events VALUES (74, 'Dummy-Player-Test', '2020-03-03 00:00:00', 1);


--
-- Name: events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('events_id_seq', 74, true);


--
-- Data for Name: player_attendance; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO player_attendance VALUES (49, '2016-08-23 00:00:00', 275, 172, NULL, 1);
INSERT INTO player_attendance VALUES (7, '2016-07-26 19:10:00', 276, 168, NULL, 1);
INSERT INTO player_attendance VALUES (62, '2020-02-07 00:00:00', 317, 169, NULL, 1);
INSERT INTO player_attendance VALUES (63, '2020-01-28 00:00:00', 317, 252, 1, 0);


--
-- Name: player_attendance_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('player_attendance_id_seq', 63, true);


--
-- Data for Name: players; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO players VALUES ('Mr. Forest Durgan', 'vpollich@rutherford.org', '1231', '7744 Boehm Shore Suite 475

Davistown, UT 29446-1950', NULL, 165, 76, NULL, NULL, 'Mr._Forest_Durgan_1580984766.jpg', 4, 270, 160, 'd', 1, '2020-02-06');
INSERT INTO players VALUES ('d1', 'd1@gmail.com', '3546', 'hghgh', NULL, 168, 77, NULL, NULL, NULL, 1, 316, 253, 'd1', 0, '2020-02-04');
INSERT INTO players VALUES ('abc', 'abc@gmail.com', '3465436', 'jhjhkjhkh', 'gjgjgj', 204, 77, NULL, NULL, 'abc_1581069927.jpg', 1, 318, 255, 'abc', 0, '2020-02-05');
INSERT INTO players VALUES ('DUMY', 'DUMY@GMAIL.COM', '32423432', 'RGSSCG', 'DFSDFGFSF', 252, 99, NULL, NULL, NULL, 1, 319, 256, 'DUMY', 0, '2020-01-30');
INSERT INTO players VALUES ('Dummy-Player', 'dummyplayer@gmail.com', '6577865778', 'test address', NULL, 252, 99, NULL, NULL, NULL, 2, 317, 254, 'dummy-parent', 0, '2017-06-06');
INSERT INTO players VALUES ('Maudie Armstrong', 'rogahn.vena@hotmail.com', '121', '575 Harvey Drive

Hudsonhaven, CA 74509-9786', 'xxxx', 172, 70, NULL, NULL, 'Maudie_Armstrong_1580981279.jpg', 2, 275, 170, 'q', 0, '2020-02-06');
INSERT INTO players VALUES ('Dr. Gertrude Leannon', 'xkautzer@schaden.com', '1234556677855', '34423 Monahan Curve Apt. 297

Rodriguezchester, MA 98999-2529', 'ZYX', 168, 73, NULL, NULL, 'Dr._Gertrude_Leannon_1580981415.jpg', 2, 276, 173, 'leannon', 0, '2020-01-15');


--
-- Name: players_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('players_id_seq', 319, true);


--
-- Data for Name: scheduling; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO scheduling VALUES (22, 276, 275, 69, 2, '2016-08-04 11:08:00', 13, NULL);
INSERT INTO scheduling VALUES (47, 316, 275, 77, 2, '2020-02-25 00:00:00', 60, 275);
INSERT INTO scheduling VALUES (49, 317, 316, 77, 3, '2020-02-08 00:00:00', 62, NULL);
INSERT INTO scheduling VALUES (48, 316, 317, 77, 2, '2020-02-12 00:00:00', 61, 317);
INSERT INTO scheduling VALUES (50, 316, 317, 75, 2, '2020-02-05 00:00:00', 63, NULL);
INSERT INTO scheduling VALUES (51, 316, 317, 77, 2, '2020-02-08 00:00:00', 64, NULL);
INSERT INTO scheduling VALUES (52, 316, 317, 77, 2, '2020-01-31 00:00:00', 65, NULL);
INSERT INTO scheduling VALUES (53, 316, 318, 77, 2, '2020-01-29 00:00:00', 66, NULL);
INSERT INTO scheduling VALUES (54, 317, 316, 77, 1, '2020-02-08 00:00:00', 69, NULL);
INSERT INTO scheduling VALUES (55, 317, 318, 78, 2, '2020-02-09 00:00:00', 70, NULL);
INSERT INTO scheduling VALUES (57, 317, 316, 70, 2, '2020-02-06 00:00:00', 72, NULL);
INSERT INTO scheduling VALUES (58, 317, 319, 99, 3, '2020-03-02 00:00:00', 73, NULL);


--
-- Name: scheduling_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('scheduling_id_seq', 58, true);


--
-- Data for Name: stance; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO stance VALUES (4, 'Counter Puncher');
INSERT INTO stance VALUES (1, 'Aggressive bAseliner');
INSERT INTO stance VALUES (2, 'All-court Player');
INSERT INTO stance VALUES (3, 'Serve and Volley Player');


--
-- Data for Name: user_log; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO user_log VALUES (18, 175, '2016-08-25 12:41:10', '2016-08-25 12:47:25');
INSERT INTO user_log VALUES (19, 175, '2016-08-25 12:47:46', '2016-08-25 12:47:59');
INSERT INTO user_log VALUES (20, 175, '2016-08-25 12:56:02', '2016-08-25 12:56:30');
INSERT INTO user_log VALUES (21, 175, '2016-08-25 13:00:46', NULL);
INSERT INTO user_log VALUES (22, 175, '2016-08-26 05:56:44', '2016-08-26 07:15:30');
INSERT INTO user_log VALUES (24, 167, '2016-08-26 08:06:23', '2016-08-26 08:29:41');
INSERT INTO user_log VALUES (27, 175, '2016-08-26 09:18:47', '2016-08-26 09:18:52');
INSERT INTO user_log VALUES (28, 160, '2016-08-26 09:19:27', '2016-08-26 09:22:05');
INSERT INTO user_log VALUES (29, 164, '2016-08-26 09:24:10', '2016-08-26 10:06:34');
INSERT INTO user_log VALUES (32, 173, '2016-08-26 12:13:28', '2016-08-26 12:21:06');
INSERT INTO user_log VALUES (33, 175, '2016-08-26 12:48:25', '2016-08-26 12:52:05');
INSERT INTO user_log VALUES (34, 175, '2016-08-26 12:56:58', '2016-08-26 13:06:20');
INSERT INTO user_log VALUES (35, 175, '2016-08-26 13:16:19', NULL);
INSERT INTO user_log VALUES (36, 175, '2016-08-27 04:44:35', '2016-08-27 05:02:04');
INSERT INTO user_log VALUES (37, 175, '2016-08-29 11:32:57', NULL);
INSERT INTO user_log VALUES (38, 175, '2016-09-19 05:12:47', NULL);
INSERT INTO user_log VALUES (39, 175, '2017-01-04 10:17:43', NULL);
INSERT INTO user_log VALUES (40, 175, '2017-01-04 10:58:04', NULL);
INSERT INTO user_log VALUES (41, 175, '2017-01-04 11:20:23', NULL);
INSERT INTO user_log VALUES (42, 175, '2017-01-04 11:20:49', NULL);
INSERT INTO user_log VALUES (43, 175, '2017-01-04 11:25:35', NULL);
INSERT INTO user_log VALUES (44, 175, '2017-01-04 11:26:26', NULL);
INSERT INTO user_log VALUES (45, 175, '2017-01-04 11:27:08', NULL);
INSERT INTO user_log VALUES (46, 175, '2017-01-04 11:28:35', NULL);
INSERT INTO user_log VALUES (47, 175, '2017-01-04 11:29:21', NULL);
INSERT INTO user_log VALUES (48, 175, '2017-01-04 11:30:16', NULL);
INSERT INTO user_log VALUES (49, 175, '2017-01-04 11:31:03', NULL);
INSERT INTO user_log VALUES (50, 175, '2017-01-04 11:32:00', NULL);
INSERT INTO user_log VALUES (51, 175, '2017-01-04 11:33:54', NULL);
INSERT INTO user_log VALUES (52, 175, '2017-01-04 11:40:50', NULL);
INSERT INTO user_log VALUES (53, 175, '2017-01-04 11:49:08', NULL);
INSERT INTO user_log VALUES (54, 175, '2017-01-04 11:50:19', NULL);
INSERT INTO user_log VALUES (55, 175, '2017-01-04 11:52:31', NULL);
INSERT INTO user_log VALUES (56, 175, '2017-01-04 12:05:31', NULL);
INSERT INTO user_log VALUES (57, 175, '2017-01-04 12:11:57', NULL);
INSERT INTO user_log VALUES (58, 175, '2017-01-07 09:34:31', '2017-01-07 09:34:38');
INSERT INTO user_log VALUES (59, 175, '2017-01-07 09:35:49', NULL);
INSERT INTO user_log VALUES (60, 175, '2017-01-07 09:39:30', NULL);
INSERT INTO user_log VALUES (61, 175, '2017-01-07 09:56:33', NULL);
INSERT INTO user_log VALUES (62, 175, '2017-01-23 08:46:42', '2017-01-23 08:53:54');
INSERT INTO user_log VALUES (63, 175, '2017-02-15 11:01:09', '2017-02-15 11:01:47');
INSERT INTO user_log VALUES (64, 175, '2017-06-22 13:37:59', NULL);
INSERT INTO user_log VALUES (65, 175, '2017-06-22 13:41:35', NULL);
INSERT INTO user_log VALUES (66, 175, '2017-06-26 10:24:17', NULL);
INSERT INTO user_log VALUES (67, 175, '2017-07-05 05:53:48', '2017-07-05 05:53:52');
INSERT INTO user_log VALUES (68, 11, '2017-07-05 07:36:19', '2017-07-05 07:36:23');
INSERT INTO user_log VALUES (69, 175, '2017-07-05 10:25:10', NULL);
INSERT INTO user_log VALUES (70, 175, '2017-07-11 10:05:56', NULL);
INSERT INTO user_log VALUES (71, 175, '2017-07-11 10:07:50', NULL);
INSERT INTO user_log VALUES (72, 175, '2017-07-15 11:23:10', NULL);
INSERT INTO user_log VALUES (73, 175, '2017-07-15 11:23:49', NULL);
INSERT INTO user_log VALUES (74, 175, '2017-07-19 06:17:45', NULL);
INSERT INTO user_log VALUES (75, 175, '2017-07-19 06:18:54', NULL);
INSERT INTO user_log VALUES (76, 175, '2017-07-19 07:09:52', NULL);
INSERT INTO user_log VALUES (77, 175, '2017-07-19 09:12:13', NULL);
INSERT INTO user_log VALUES (78, 175, '2017-07-20 07:20:47', NULL);
INSERT INTO user_log VALUES (79, 175, '2017-07-20 13:50:14', NULL);
INSERT INTO user_log VALUES (80, 175, '2017-08-18 17:45:02', '2017-08-18 17:45:26');
INSERT INTO user_log VALUES (81, 175, '2017-09-02 11:15:39', '2017-09-02 11:15:44');
INSERT INTO user_log VALUES (82, 175, '2017-12-16 06:08:51', NULL);
INSERT INTO user_log VALUES (83, 175, '2018-01-25 12:33:53', '2018-01-25 12:34:09');
INSERT INTO user_log VALUES (84, 175, '2018-01-25 12:34:15', '2018-01-25 12:34:31');
INSERT INTO user_log VALUES (85, 175, '2018-01-25 12:34:57', NULL);
INSERT INTO user_log VALUES (86, 175, '2018-02-14 11:49:36', NULL);
INSERT INTO user_log VALUES (87, 175, '2018-06-18 09:30:07', NULL);
INSERT INTO user_log VALUES (88, 175, '2019-01-09 08:36:08', '2019-01-09 08:36:28');
INSERT INTO user_log VALUES (89, 175, '2019-01-09 08:36:34', NULL);
INSERT INTO user_log VALUES (90, 175, '2019-01-09 08:38:12', NULL);
INSERT INTO user_log VALUES (91, 175, '2019-01-09 11:06:30', NULL);
INSERT INTO user_log VALUES (92, 175, '2019-01-11 09:22:50', '2019-01-11 09:31:42');
INSERT INTO user_log VALUES (93, 175, '2019-01-11 09:31:47', '2019-01-11 09:31:50');
INSERT INTO user_log VALUES (94, 175, '2019-01-11 09:45:29', NULL);
INSERT INTO user_log VALUES (95, 175, '2019-01-11 09:53:14', NULL);
INSERT INTO user_log VALUES (97, 175, '2019-01-16 09:17:44', NULL);
INSERT INTO user_log VALUES (98, 175, '2019-01-16 11:47:48', '2019-01-16 11:50:49');
INSERT INTO user_log VALUES (99, 175, '2019-01-16 11:51:00', '2019-01-16 11:52:39');
INSERT INTO user_log VALUES (100, 175, '2019-01-16 11:53:12', NULL);
INSERT INTO user_log VALUES (96, 175, '2019-01-16 08:50:42', '2019-01-16 13:13:57');
INSERT INTO user_log VALUES (101, 175, '2019-01-16 13:34:04', NULL);
INSERT INTO user_log VALUES (102, 175, '2019-02-14 06:46:14', '2019-02-14 07:55:21');
INSERT INTO user_log VALUES (103, 175, '2019-02-14 07:56:43', NULL);
INSERT INTO user_log VALUES (104, 175, '2019-02-14 13:05:43', '2019-02-14 13:21:18');
INSERT INTO user_log VALUES (105, 175, '2019-02-16 08:42:01', '2019-02-16 09:44:20');
INSERT INTO user_log VALUES (106, 175, '2020-02-05 04:52:21', '2020-02-05 04:54:37');
INSERT INTO user_log VALUES (107, 175, '2020-02-05 08:00:53', NULL);
INSERT INTO user_log VALUES (108, 175, '2020-02-05 11:30:27', NULL);
INSERT INTO user_log VALUES (109, 175, '2020-02-05 11:43:58', NULL);
INSERT INTO user_log VALUES (110, 175, '2020-02-05 11:45:32', '2020-02-05 11:47:45');
INSERT INTO user_log VALUES (111, 175, '2020-02-05 11:48:38', '2020-02-05 12:29:31');
INSERT INTO user_log VALUES (112, 175, '2020-02-06 06:08:29', NULL);
INSERT INTO user_log VALUES (113, 175, '2020-02-06 06:20:15', '2020-02-06 07:14:49');
INSERT INTO user_log VALUES (114, 175, '2020-02-06 07:15:37', '2020-02-06 07:19:48');
INSERT INTO user_log VALUES (116, 175, '2020-02-06 07:48:57', NULL);
INSERT INTO user_log VALUES (115, 175, '2020-02-06 07:20:13', '2020-02-06 13:26:05');
INSERT INTO user_log VALUES (118, 175, '2020-02-07 05:01:45', NULL);
INSERT INTO user_log VALUES (119, 175, '2020-02-07 06:09:24', '2020-02-07 06:12:34');
INSERT INTO user_log VALUES (120, 175, '2020-02-07 06:12:50', '2020-02-07 06:13:05');
INSERT INTO user_log VALUES (117, 175, '2020-02-07 04:55:31', '2020-02-07 06:41:57');
INSERT INTO user_log VALUES (124, 175, '2020-02-07 07:13:32', NULL);
INSERT INTO user_log VALUES (123, 175, '2020-02-07 07:11:22', '2020-02-07 07:14:45');
INSERT INTO user_log VALUES (125, 175, '2020-02-07 07:15:16', NULL);
INSERT INTO user_log VALUES (127, 175, '2020-02-07 08:03:57', NULL);
INSERT INTO user_log VALUES (122, 175, '2020-02-07 06:42:08', '2020-02-07 08:51:08');
INSERT INTO user_log VALUES (128, 175, '2020-02-07 08:51:13', '2020-02-07 08:51:16');
INSERT INTO user_log VALUES (129, 165, '2020-02-07 08:55:07', '2020-02-07 09:00:24');
INSERT INTO user_log VALUES (130, 252, '2020-02-07 09:00:34', '2020-02-07 09:01:08');
INSERT INTO user_log VALUES (131, 175, '2020-02-07 09:01:14', '2020-02-07 09:05:23');
INSERT INTO user_log VALUES (132, 254, '2020-02-07 09:05:34', NULL);
INSERT INTO user_log VALUES (121, 175, '2020-02-07 06:13:57', '2020-02-07 09:11:01');
INSERT INTO user_log VALUES (126, 175, '2020-02-07 07:26:20', '2020-02-07 09:11:57');
INSERT INTO user_log VALUES (133, 252, '2020-02-07 09:12:42', NULL);
INSERT INTO user_log VALUES (134, 252, '2020-02-07 09:15:16', '2020-02-07 09:15:34');
INSERT INTO user_log VALUES (135, 175, '2020-02-07 09:15:53', '2020-02-07 09:18:46');
INSERT INTO user_log VALUES (137, 175, '2020-02-07 09:38:26', NULL);
INSERT INTO user_log VALUES (138, 175, '2020-02-07 09:44:25', NULL);
INSERT INTO user_log VALUES (136, 175, '2020-02-07 09:20:26', '2020-02-07 09:50:12');
INSERT INTO user_log VALUES (139, 175, '2020-02-07 09:50:53', NULL);
INSERT INTO user_log VALUES (141, 175, '2020-02-07 10:20:29', NULL);
INSERT INTO user_log VALUES (140, 252, '2020-02-07 09:51:16', '2020-02-07 10:59:19');
INSERT INTO user_log VALUES (142, 175, '2020-02-07 10:59:42', '2020-02-07 11:02:58');
INSERT INTO user_log VALUES (143, 252, '2020-02-07 11:03:56', '2020-02-07 11:23:23');
INSERT INTO user_log VALUES (145, 254, '2020-02-07 11:23:44', '2020-02-07 11:52:29');
INSERT INTO user_log VALUES (144, 175, '2020-02-07 11:16:03', '2020-02-07 11:52:38');
INSERT INTO user_log VALUES (147, 175, '2020-02-07 13:08:01', NULL);
INSERT INTO user_log VALUES (146, 175, '2020-02-07 13:05:16', '2020-02-07 13:50:23');
INSERT INTO user_log VALUES (148, 252, '2020-02-07 14:14:53', NULL);
INSERT INTO user_log VALUES (149, 175, '2020-02-08 15:55:26', NULL);
INSERT INTO user_log VALUES (150, 175, '2020-02-09 02:59:27', NULL);


--
-- Name: user_log_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('user_log_id_seq', 150, true);


--
-- Data for Name: user_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO user_types VALUES (0, 'admin');
INSERT INTO user_types VALUES (1, 'coach');
INSERT INTO user_types VALUES (2, 'parent');
INSERT INTO user_types VALUES (3, 'player');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO users VALUES (204, 'russel ', 'russel@test.in', '09e6e59906fb5d73414e078965ac7c54', 1, NULL, NULL, NULL, NULL, 'isynR4z7', 0);
INSERT INTO users VALUES (207, 'Amrit Rathi', '123amrit@gmail.com', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (173, 'Dr. Gertrude Leann', 'xkautzer@schaden.com', 'e99a18c428cb38d5f260853678922e03', 3, NULL, NULL, '1983-08-23 10:28:56', '1995-02-18 07:03:16', NULL, 1);
INSERT INTO users VALUES (160, 'Mr. Forest Durgan', 'vpollich@rutherford.org', 'e99a18c428cb38d5f260853678922e03', 3, NULL, NULL, '2012-07-19 11:32:57', '1994-02-17 14:40:21', NULL, 1);
INSERT INTO users VALUES (162, 'Prof. Adrian D''Amore DVM', 'cmitchell@gmail.com', 'e99a18c428cb38d5f260853678922e03', 3, NULL, NULL, '1981-04-19 14:41:15', '2013-06-27 21:48:42', NULL, 1);
INSERT INTO users VALUES (163, 'Amelia Monahan', 'nikolaus.nicolette@yahoo.com', 'e99a18c428cb38d5f260853678922e03', 1, NULL, NULL, '2002-09-26 19:58:48', '1971-08-21 06:53:53', NULL, 1);
INSERT INTO users VALUES (165, 'Prof. Lorenzo Friesen', 'otilia.emard@gmail.com', 'e99a18c428cb38d5f260853678922e03', 1, NULL, NULL, '1996-07-17 00:36:41', '1977-07-21 01:45:12', NULL, 1);
INSERT INTO users VALUES (164, 'Chaya Lowe', 'quigley.tyra@yahoo.com', 'e99a18c428cb38d5f260853678922e03', 3, NULL, NULL, '1989-03-19 07:08:19', '1972-10-11 20:34:43', NULL, 1);
INSERT INTO users VALUES (166, 'Lorena Anderson Sr.', 'gerson87@turner.net', 'e99a18c428cb38d5f260853678922e03', 3, NULL, NULL, '1973-12-14 01:17:03', '2008-07-30 22:40:25', NULL, 1);
INSERT INTO users VALUES (167, 'Vernon Morar', 'baumbach.kaylie@wintheiser.org', 'e99a18c428cb38d5f260853678922e03', 3, NULL, NULL, '1975-12-25 13:36:07', '2011-01-27 07:54:31', NULL, 1);
INSERT INTO users VALUES (169, 'Melody Bednar', 'princess60@gmail.com', 'e99a18c428cb38d5f260853678922e03', 1, NULL, NULL, '2011-01-19 21:59:09', '2003-01-12 00:58:11', NULL, 1);
INSERT INTO users VALUES (168, 'Kaylah Kerluke DDS', 'jannie.lang@sanford.com', 'e99a18c428cb38d5f260853678922e03', 1, NULL, NULL, '1993-02-20 10:10:10', '1994-05-12 22:12:37', NULL, 1);
INSERT INTO users VALUES (170, 'Maudie Armstrong', 'rogahn.vena@hotmail.com', 'e99a18c428cb38d5f260853678922e03', 3, NULL, NULL, '1993-07-21 01:46:39', '2007-03-15 12:49:29', NULL, 1);
INSERT INTO users VALUES (171, 'Odell Heller', 'antonietta.marvin@schultz.com', 'e99a18c428cb38d5f260853678922e03', 1, NULL, NULL, '1977-09-26 21:47:57', '2007-08-28 13:50:02', NULL, 1);
INSERT INTO users VALUES (172, 'Darien Herman', 'major.hermiston@reichert.com', 'e99a18c428cb38d5f260853678922e03', 1, NULL, NULL, '1976-10-17 22:03:32', '2010-04-07 00:48:08', NULL, 1);
INSERT INTO users VALUES (203, 'mehul', 'mehul@test.in', NULL, 3, 'C:\wamp\tmp\phpEB17.tmp', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (216, 'scvdsf', 'shyams@gmail.comf', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (11, 'Mahhi', 'mahendrabod76@gmail.com', 'e99a18c428cb38d5f260853678922e03', 2, 'mahhi_1467785255.jpg', NULL, NULL, NULL, NULL, 1);
INSERT INTO users VALUES (249, 'test3', 'test3@gmail.com', NULL, 3, 'test3_1581061076.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (250, 'hkjhjk', 'jkhkjhjk@hh.com', NULL, 3, 'hkjhjk_1581062683.png', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (251, 'demo0', 'demo0@gmail.com', NULL, 3, 'demo0_1581064434.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (253, 'd1', 'd1@gmail.com', NULL, 3, 'd1_1581065809.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (236, 'T', 'T@gmail.com', NULL, 3, 'T_1580994495.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (237, 'test', 'test@abc.com', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (238, 'test', 'tetst@hh.com', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (239, 'test', 'tetst@hh.com', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (240, 'demo4', 'demo4@gmail.com', NULL, 3, 'demo4_1581056259.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (241, 'd5', 'd5@gmail.com', NULL, 3, 'd5_1581056886.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (242, 'd6', 'd6@gmail.com', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (243, 'demo1', 'demo1@gmail.com', NULL, 3, 'demo1_1581057523.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (244, 'ttt', 'tt@ff.com', NULL, 3, 'ttt_1581058219.png', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (245, 'd2', 'd2@gmail.com', NULL, 3, 'd2_1581059426.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (246, 'd3', 'd3@gmail.com', NULL, 3, 'd3_1581059591.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (247, 'test', 'test@gmail.com', NULL, 3, 'test_1581059827.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (248, 'test2', 'test2@gmail.com', NULL, 3, 'test2_1581060476.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (254, 'Dummy-Player', 'dummyplayer@gmail.com', 'e99a18c428cb38d5f260853678922e03', 3, NULL, NULL, NULL, NULL, NULL, 1);
INSERT INTO users VALUES (175, 'Admin', 'admin@gmail.com', 'e99a18c428cb38d5f260853678922e03', 0, 'Admin1_1581058000.jpg', NULL, NULL, NULL, NULL, 1);
INSERT INTO users VALUES (252, 'Dummy-coach', 'dummycoach@gmail.com', 'e99a18c428cb38d5f260853678922e03', 1, 'Dummy-coach_1581069436.jpg', NULL, NULL, NULL, '^7fNv*l8', 1);
INSERT INTO users VALUES (255, 'abc', 'abc@gmail.com', NULL, 3, 'abc_1581069826.jpg', NULL, NULL, NULL, NULL, NULL);
INSERT INTO users VALUES (256, 'DUMY', 'DUMY@GMAIL.COM', NULL, 3, 'DUMY_1581081430.jpg', NULL, NULL, NULL, NULL, NULL);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 256, true);


--
-- Name: academies academies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY academies
    ADD CONSTRAINT academies_pkey PRIMARY KEY (id);


--
-- Name: academy_coaches academy_coaches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY academy_coaches
    ADD CONSTRAINT academy_coaches_pkey PRIMARY KEY (id);


--
-- Name: academy_court academy_court_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY academy_court
    ADD CONSTRAINT academy_court_pkey PRIMARY KEY (id);


--
-- Name: anonymous_feedback anonymous_feedback_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY anonymous_feedback
    ADD CONSTRAINT anonymous_feedback_pkey PRIMARY KEY (id);


--
-- Name: assessments assessment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY assessments
    ADD CONSTRAINT assessment_pkey PRIMARY KEY (id);


--
-- Name: coach_attendance coach_attendance_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY coach_attendance
    ADD CONSTRAINT coach_attendance_pkey PRIMARY KEY (id);


--
-- Name: court_types court_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY court_types
    ADD CONSTRAINT court_types_pkey PRIMARY KEY (id);


--
-- Name: drill_images drill_images_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drill_images
    ADD CONSTRAINT drill_images_pkey PRIMARY KEY (id);


--
-- Name: drill_players drill_players_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drill_players
    ADD CONSTRAINT drill_players_pkey PRIMARY KEY (id);


--
-- Name: drills drills_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drills
    ADD CONSTRAINT drills_pkey PRIMARY KEY (id);


--
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- Name: player_attendance player_attendance_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY player_attendance
    ADD CONSTRAINT player_attendance_pkey PRIMARY KEY (id);


--
-- Name: players players_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players
    ADD CONSTRAINT players_pkey PRIMARY KEY (id);


--
-- Name: scheduling scheduling_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY scheduling
    ADD CONSTRAINT scheduling_pkey PRIMARY KEY (id);


--
-- Name: stance stance_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY stance
    ADD CONSTRAINT stance_pkey PRIMARY KEY (id);


--
-- Name: user_log user_log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_log
    ADD CONSTRAINT user_log_pkey PRIMARY KEY (id);


--
-- Name: user_types user_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_types
    ADD CONSTRAINT user_types_pkey PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: academy_coaches academy_coaches_academy_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY academy_coaches
    ADD CONSTRAINT academy_coaches_academy_id_fkey FOREIGN KEY (academy_id) REFERENCES academies(id) ON DELETE CASCADE;


--
-- Name: academy_coaches academy_coaches_coach_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY academy_coaches
    ADD CONSTRAINT academy_coaches_coach_id_fkey FOREIGN KEY (coach_id) REFERENCES users(id) ON DELETE CASCADE;


--
-- Name: coach_attendance coach_attendance_coach_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY coach_attendance
    ADD CONSTRAINT coach_attendance_coach_id_fkey FOREIGN KEY (coach_id) REFERENCES users(id) ON DELETE CASCADE;


--
-- Name: drill_players drill_players_drill_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drill_players
    ADD CONSTRAINT drill_players_drill_id_fkey FOREIGN KEY (drill_id) REFERENCES drills(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: drill_players drill_players_event_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drill_players
    ADD CONSTRAINT drill_players_event_id_fkey FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE;


--
-- Name: drill_players drill_players_player_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY drill_players
    ADD CONSTRAINT drill_players_player_id_fkey FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE;


--
-- Name: player_attendance player_attendance_coach_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY player_attendance
    ADD CONSTRAINT player_attendance_coach_id_fkey FOREIGN KEY (coach_id) REFERENCES users(id) ON DELETE CASCADE;


--
-- Name: player_attendance player_attendance_player_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY player_attendance
    ADD CONSTRAINT player_attendance_player_id_fkey FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE;


--
-- Name: players players_coach_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players
    ADD CONSTRAINT players_coach_fkey FOREIGN KEY (coachid) REFERENCES users(id) ON DELETE CASCADE;


--
-- Name: players players_stance_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players
    ADD CONSTRAINT players_stance_fkey FOREIGN KEY (stanceid) REFERENCES stance(id) ON DELETE CASCADE;


--
-- Name: players players_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players
    ADD CONSTRAINT players_user_id_fkey FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;


--
-- Name: scheduling scheduling_player1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY scheduling
    ADD CONSTRAINT scheduling_player1_fkey FOREIGN KEY (player1) REFERENCES players(id) ON DELETE CASCADE;


--
-- Name: scheduling scheduling_player2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY scheduling
    ADD CONSTRAINT scheduling_player2_fkey FOREIGN KEY (player2) REFERENCES players(id) ON DELETE CASCADE;


--
-- Name: user_log user_log_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_log
    ADD CONSTRAINT user_log_user_id_fkey FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: users users_user_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_user_type_fkey FOREIGN KEY (user_type) REFERENCES user_types(id);


--
-- PostgreSQL database dump complete
--


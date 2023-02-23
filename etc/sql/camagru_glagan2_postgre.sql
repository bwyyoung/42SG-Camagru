--
-- PostgreSQL database dump
--

-- Dumped from database version 15.1
-- Dumped by pg_dump version 15.1

-- Started on 2023-02-23 19:01:57

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 6 (class 2615 OID 16402)
-- Name: camagru_glagan; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA camagru_glagan;


ALTER SCHEMA camagru_glagan OWNER TO postgres;

--
-- TOC entry 858 (class 1247 OID 16683)
-- Name: decorations_position; Type: TYPE; Schema: camagru_glagan; Owner: postgres
--

CREATE TYPE camagru_glagan.decorations_position AS ENUM (
    'top-left',
    'top-center',
    'top-right',
    'center-left',
    'center-center',
    'center-right',
    'bottom-left',
    'bottom-center',
    'bottom-right'
);


ALTER TYPE camagru_glagan.decorations_position OWNER TO postgres;

--
-- TOC entry 861 (class 1247 OID 16702)
-- Name: usertokens_scope; Type: TYPE; Schema: camagru_glagan; Owner: postgres
--

CREATE TYPE camagru_glagan.usertokens_scope AS ENUM (
    'verification',
    'password'
);


ALTER TYPE camagru_glagan.usertokens_scope OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 221 (class 1259 OID 16708)
-- Name: comments; Type: TABLE; Schema: camagru_glagan; Owner: postgres
--

CREATE TABLE camagru_glagan.comments (
    id bigint NOT NULL,
    image bigint NOT NULL,
    "user" bigint NOT NULL,
    message text NOT NULL,
    at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE camagru_glagan.comments OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16707)
-- Name: comments_id_seq; Type: SEQUENCE; Schema: camagru_glagan; Owner: postgres
--

CREATE SEQUENCE camagru_glagan.comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE camagru_glagan.comments_id_seq OWNER TO postgres;

--
-- TOC entry 3427 (class 0 OID 0)
-- Dependencies: 220
-- Name: comments_id_seq; Type: SEQUENCE OWNED BY; Schema: camagru_glagan; Owner: postgres
--

ALTER SEQUENCE camagru_glagan.comments_id_seq OWNED BY camagru_glagan.comments.id;


--
-- TOC entry 223 (class 1259 OID 16716)
-- Name: creations; Type: TABLE; Schema: camagru_glagan; Owner: postgres
--

CREATE TABLE camagru_glagan.creations (
    id bigint NOT NULL,
    "user" bigint NOT NULL,
    name character varying(250) NOT NULL,
    animated smallint DEFAULT '0'::smallint NOT NULL,
    at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE camagru_glagan.creations OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 16715)
-- Name: creations_id_seq; Type: SEQUENCE; Schema: camagru_glagan; Owner: postgres
--

CREATE SEQUENCE camagru_glagan.creations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE camagru_glagan.creations_id_seq OWNER TO postgres;

--
-- TOC entry 3428 (class 0 OID 0)
-- Dependencies: 222
-- Name: creations_id_seq; Type: SEQUENCE OWNED BY; Schema: camagru_glagan; Owner: postgres
--

ALTER SEQUENCE camagru_glagan.creations_id_seq OWNED BY camagru_glagan.creations.id;


--
-- TOC entry 225 (class 1259 OID 16723)
-- Name: decorations; Type: TABLE; Schema: camagru_glagan; Owner: postgres
--

CREATE TABLE camagru_glagan.decorations (
    id bigint NOT NULL,
    name character varying(250) NOT NULL,
    animated smallint DEFAULT '0'::smallint NOT NULL,
    public boolean DEFAULT true NOT NULL,
    "position" camagru_glagan.decorations_position DEFAULT 'top-left'::camagru_glagan.decorations_position NOT NULL
);


ALTER TABLE camagru_glagan.decorations OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 16722)
-- Name: decorations_id_seq; Type: SEQUENCE; Schema: camagru_glagan; Owner: postgres
--

CREATE SEQUENCE camagru_glagan.decorations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE camagru_glagan.decorations_id_seq OWNER TO postgres;

--
-- TOC entry 3429 (class 0 OID 0)
-- Dependencies: 224
-- Name: decorations_id_seq; Type: SEQUENCE OWNED BY; Schema: camagru_glagan; Owner: postgres
--

ALTER SEQUENCE camagru_glagan.decorations_id_seq OWNED BY camagru_glagan.decorations.id;


--
-- TOC entry 227 (class 1259 OID 16731)
-- Name: likes; Type: TABLE; Schema: camagru_glagan; Owner: postgres
--

CREATE TABLE camagru_glagan.likes (
    id bigint NOT NULL,
    "user" bigint NOT NULL,
    image bigint NOT NULL,
    at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE camagru_glagan.likes OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 16730)
-- Name: likes_id_seq; Type: SEQUENCE; Schema: camagru_glagan; Owner: postgres
--

CREATE SEQUENCE camagru_glagan.likes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE camagru_glagan.likes_id_seq OWNER TO postgres;

--
-- TOC entry 3430 (class 0 OID 0)
-- Dependencies: 226
-- Name: likes_id_seq; Type: SEQUENCE OWNED BY; Schema: camagru_glagan; Owner: postgres
--

ALTER SEQUENCE camagru_glagan.likes_id_seq OWNED BY camagru_glagan.likes.id;


--
-- TOC entry 229 (class 1259 OID 16737)
-- Name: users; Type: TABLE; Schema: camagru_glagan; Owner: postgres
--

CREATE TABLE camagru_glagan.users (
    id bigint NOT NULL,
    username character varying(250) NOT NULL,
    email character varying(250) NOT NULL,
    password character varying(250) NOT NULL,
    verified smallint DEFAULT '0'::smallint NOT NULL,
    receivecomments smallint DEFAULT '1'::smallint NOT NULL
);


ALTER TABLE camagru_glagan.users OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 16736)
-- Name: users_id_seq; Type: SEQUENCE; Schema: camagru_glagan; Owner: postgres
--

CREATE SEQUENCE camagru_glagan.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE camagru_glagan.users_id_seq OWNER TO postgres;

--
-- TOC entry 3431 (class 0 OID 0)
-- Dependencies: 228
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: camagru_glagan; Owner: postgres
--

ALTER SEQUENCE camagru_glagan.users_id_seq OWNED BY camagru_glagan.users.id;


--
-- TOC entry 231 (class 1259 OID 16746)
-- Name: usersessions; Type: TABLE; Schema: camagru_glagan; Owner: postgres
--

CREATE TABLE camagru_glagan.usersessions (
    id bigint NOT NULL,
    usersid bigint NOT NULL,
    session character varying(250) NOT NULL,
    issued timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    rememberme smallint DEFAULT '0'::smallint NOT NULL
);


ALTER TABLE camagru_glagan.usersessions OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 16745)
-- Name: usersessions_id_seq; Type: SEQUENCE; Schema: camagru_glagan; Owner: postgres
--

CREATE SEQUENCE camagru_glagan.usersessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE camagru_glagan.usersessions_id_seq OWNER TO postgres;

--
-- TOC entry 3432 (class 0 OID 0)
-- Dependencies: 230
-- Name: usersessions_id_seq; Type: SEQUENCE OWNED BY; Schema: camagru_glagan; Owner: postgres
--

ALTER SEQUENCE camagru_glagan.usersessions_id_seq OWNED BY camagru_glagan.usersessions.id;


--
-- TOC entry 233 (class 1259 OID 16753)
-- Name: usertokens; Type: TABLE; Schema: camagru_glagan; Owner: postgres
--

CREATE TABLE camagru_glagan.usertokens (
    id bigint NOT NULL,
    "user" bigint NOT NULL,
    token character varying(50) NOT NULL,
    scope camagru_glagan.usertokens_scope NOT NULL,
    issued timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE camagru_glagan.usertokens OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 16752)
-- Name: usertokens_id_seq; Type: SEQUENCE; Schema: camagru_glagan; Owner: postgres
--

CREATE SEQUENCE camagru_glagan.usertokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE camagru_glagan.usertokens_id_seq OWNER TO postgres;

--
-- TOC entry 3433 (class 0 OID 0)
-- Dependencies: 232
-- Name: usertokens_id_seq; Type: SEQUENCE OWNED BY; Schema: camagru_glagan; Owner: postgres
--

ALTER SEQUENCE camagru_glagan.usertokens_id_seq OWNED BY camagru_glagan.usertokens.id;


--
-- TOC entry 3217 (class 2604 OID 16711)
-- Name: comments id; Type: DEFAULT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.comments ALTER COLUMN id SET DEFAULT nextval('camagru_glagan.comments_id_seq'::regclass);


--
-- TOC entry 3219 (class 2604 OID 16719)
-- Name: creations id; Type: DEFAULT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.creations ALTER COLUMN id SET DEFAULT nextval('camagru_glagan.creations_id_seq'::regclass);


--
-- TOC entry 3222 (class 2604 OID 16726)
-- Name: decorations id; Type: DEFAULT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.decorations ALTER COLUMN id SET DEFAULT nextval('camagru_glagan.decorations_id_seq'::regclass);


--
-- TOC entry 3226 (class 2604 OID 16734)
-- Name: likes id; Type: DEFAULT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.likes ALTER COLUMN id SET DEFAULT nextval('camagru_glagan.likes_id_seq'::regclass);


--
-- TOC entry 3228 (class 2604 OID 16740)
-- Name: users id; Type: DEFAULT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.users ALTER COLUMN id SET DEFAULT nextval('camagru_glagan.users_id_seq'::regclass);


--
-- TOC entry 3231 (class 2604 OID 16749)
-- Name: usersessions id; Type: DEFAULT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.usersessions ALTER COLUMN id SET DEFAULT nextval('camagru_glagan.usersessions_id_seq'::regclass);


--
-- TOC entry 3234 (class 2604 OID 16756)
-- Name: usertokens id; Type: DEFAULT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.usertokens ALTER COLUMN id SET DEFAULT nextval('camagru_glagan.usertokens_id_seq'::regclass);


--
-- TOC entry 3409 (class 0 OID 16708)
-- Dependencies: 221
-- Data for Name: comments; Type: TABLE DATA; Schema: camagru_glagan; Owner: postgres
--

COPY camagru_glagan.comments (id, image, "user", message, at) FROM stdin;
1	1	4	alienPls	2021-04-12 19:19:00+08
2	7	4	What anime is this ?	2021-04-12 19:19:28+08
3	10	4	I don't even know what this means.	2021-04-12 19:19:45+08
4	9	4	??	2021-04-12 19:19:51+08
5	6	4	SSSsss	2021-04-12 19:21:01+08
6	11	4	I wish I was there...	2021-04-12 19:21:20+08
7	13	4	I think it's your worst creation.	2021-04-12 19:21:45+08
8	15	4	2min game ? Is that even possible ??	2021-04-12 19:21:59+08
9	18	4	He looks so happy !	2021-04-12 19:22:29+08
10	21	4	He's sooo big !	2021-04-12 19:23:10+08
11	22	4	Poor cat :(	2021-04-12 19:23:19+08
12	26	4	Jail time baby	2021-04-12 19:23:37+08
13	25	4	He's so fast !!	2021-04-12 19:23:47+08
14	27	4	Isn't he cute ? :)	2021-04-12 19:56:41+08
15	1	2	Space is so mysterious and beautiful.	2021-04-12 20:04:02+08
16	2	2	I can't legally say anything about that.	2021-04-12 20:04:19+08
17	4	2	I tried but I failed.	2021-04-12 20:04:56+08
18	5	2	AAAAAAAAAAaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaahhhhhhhhhhhhhhhh	2021-04-12 20:05:06+08
19	6	2	Nice drawing.	2021-04-12 20:05:17+08
20	7	2	Is she dead D:	2021-04-12 20:05:30+08
21	9	2	I get the reference.	2021-04-12 20:05:48+08
22	10	2	Hum, I think it works.	2021-04-12 20:06:02+08
23	12	2	Where's the cat ?	2021-04-12 20:08:29+08
24	14	2	I should learn python.	2021-04-12 20:08:50+08
25	16	2	This was a nice game.	2021-04-12 20:09:10+08
26	17	2	No @Eva I think *this* is his worst creation.	2021-04-12 20:09:38+08
27	19	2	This looks great.	2021-04-12 20:10:58+08
28	20	2	Really sneaky, I couldn't see them.	2021-04-12 20:11:14+08
29	4	3	Try harder then.	2021-04-12 20:11:53+08
30	1	3	Indeed it is.	2021-04-12 20:12:04+08
31	2	3	Aren't you anonymous ?	2021-04-12 20:12:18+08
32	5	3	He's going super saiyan !!!	2021-04-12 20:12:35+08
33	7	3	I think it's Yuru Yuri or something like that	2021-04-12 20:13:01+08
34	10	3	There is an error.	2021-04-12 20:13:15+08
35	10	3	Nevermind I'm just really bad at coding.	2021-04-12 20:13:26+08
36	27	3	Woaf	2021-04-12 20:13:49+08
37	27	3	He's really cute @Eva	2021-04-12 20:13:56+08
38	14	3	<script type="application/javascript">alert('Does *this* work ?');</script>	2021-04-12 20:22:52+08
39	14	3	<b>Maybe this ?</b>	2021-04-12 20:23:11+08
40	14	3	<div class="text-right">Ok I think it's good.</div>	2021-04-12 20:23:31+08
\.


--
-- TOC entry 3411 (class 0 OID 16716)
-- Dependencies: 223
-- Data for Name: creations; Type: TABLE DATA; Schema: camagru_glagan; Owner: postgres
--

COPY camagru_glagan.creations (id, "user", name, animated, at) FROM stdin;
1	1	155146_70b2e33292.webm	1	2021-04-12 15:52:04+08
2	2	155316_b6b0ff339f.png	0	2021-04-12 15:53:17+08
3	1	155510_47a3c95e21.webm	1	2021-04-12 15:55:12+08
4	1	155607_cebaf9f25d.png	0	2021-04-12 15:56:07+08
5	3	155718_f1bcf65470.webm	1	2021-04-12 15:57:20+08
6	1	155824_62c66cce01.png	0	2021-04-12 15:58:25+08
7	1	160000_16572455a1.webm	1	2021-04-12 16:00:04+08
8	2	160042_da41b8296a.png	0	2021-04-12 16:00:42+08
9	1	160126_2836d161df.webm	1	2021-04-12 16:01:35+08
10	1	175956_b7da172af9.webm	1	2021-04-12 17:59:59+08
11	2	180346_3e033260d9.png	0	2021-04-12 18:03:47+08
12	1	180654_d82712205b.png	0	2021-04-12 18:06:55+08
13	3	180940_6576924806.png	0	2021-04-12 18:09:41+08
14	1	182750_b0236a1ece.png	0	2021-04-12 18:27:51+08
15	3	183015_d1282064ce.png	0	2021-04-12 18:30:16+08
16	1	183749_80fcd6108b.png	0	2021-04-12 18:37:49+08
17	2	183933_2b243f1f4b.png	0	2021-04-12 18:39:33+08
18	1	184108_913e6969bc.png	0	2021-04-12 18:41:08+08
19	3	184119_8cecfd3b90.png	0	2021-04-12 18:41:19+08
20	2	184159_4dd95dea22.png	0	2021-04-12 18:41:59+08
21	1	184242_0933c85c4d.png	0	2021-04-12 18:42:42+08
22	3	184348_8e3c71c905.png	0	2021-04-12 18:43:50+08
23	2	184422_d419e3902b.webm	1	2021-04-12 18:44:27+08
24	3	184504_d3df02c38c.webm	1	2021-04-12 18:45:14+08
25	1	184537_53a5598f74.png	0	2021-04-12 18:45:38+08
26	1	184634_52cf6f8506.png	0	2021-04-12 18:46:35+08
27	1	195626_f57e9db4ee.webm	1	2021-04-12 19:56:28+08
\.


--
-- TOC entry 3413 (class 0 OID 16723)
-- Dependencies: 225
-- Data for Name: decorations; Type: TABLE DATA; Schema: camagru_glagan; Owner: postgres
--

COPY camagru_glagan.decorations (id, name, animated, public, "position") FROM stdin;
1	001.png	0	t	center-center
2	002.png	0	t	bottom-left
3	003.png	0	t	center-center
4	004.png	0	t	bottom-right
5	005.png	0	t	bottom-left
6	006.png	0	t	top-left
7	007.png	0	t	bottom-right
8	008.png	0	t	top-left
9	009.png	0	t	bottom-right
10	010.png	0	t	bottom-left
11	011.png	0	t	bottom-center
12	012.png	0	t	bottom-left
13	013.png	0	t	bottom-left
14	014.png	0	t	bottom-left
15	015.png	0	t	bottom-left
16	016.png	0	t	bottom-right
17	017.png	0	t	bottom-right
18	018.png	0	t	bottom-left
19	019.png	0	t	bottom-right
20	020.png	0	t	bottom-center
21	021.png	0	f	top-right
22	022.png	0	t	bottom-right
23	023.png	0	t	bottom-left
24	024.png	0	t	bottom-center
25	025.png	0	t	bottom-center
26	026.png	0	t	bottom-right
27	027.png	0	t	bottom-right
28	028.png	0	t	center-center
29	029.png	0	t	bottom-left
30	030.png	0	t	bottom-center
31	031.png	0	t	bottom-left
32	032.png	0	t	bottom-left
33	033.png	0	t	bottom-right
34	034.png	0	t	center-center
35	035.png	0	t	center-center
36	036.png	0	t	bottom-left
37	037.png	0	t	bottom-right
38	038.png	0	t	bottom-left
39	039.png	0	t	bottom-left
40	040.png	0	t	bottom-center
41	041.png	0	t	bottom-left
42	042.png	0	t	center-center
43	043.png	0	t	bottom-right
44	044.png	0	t	bottom-left
45	045.png	0	t	bottom-center
46	046.png	0	t	bottom-center
47	047.png	0	t	center-center
48	048.png	0	t	bottom-left
49	049.png	0	t	bottom-left
50	050.png	0	t	bottom-left
51	051.png	0	t	top-right
52	052.png	0	t	center-left
53	053.png	0	t	bottom-right
54	054.png	0	t	bottom-left
55	055.png	0	t	bottom-left
56	056.png	0	t	bottom-left
57	057.png	0	t	bottom-left
58	058.png	0	t	top-right
59	059.png	0	t	bottom-center
60	060.png	0	t	bottom-center
61	061.png	0	t	bottom-center
62	062.png	0	t	bottom-center
63	063.png	0	t	bottom-center
64	064.png	0	t	bottom-right
65	065.png	0	t	center-center
66	066.png	0	t	bottom-center
67	067.png	0	t	bottom-center
68	068.png	0	t	bottom-right
69	069.png	0	t	bottom-center
70	070.png	0	t	bottom-center
71	071.png	0	t	bottom-left
72	072.png	0	t	bottom-center
73	073.png	0	t	center-center
74	074.png	0	t	center-center
75	075.png	0	t	bottom-right
76	076.png	0	t	bottom-left
77	077.png	0	t	bottom-left
78	078.png	0	t	bottom-right
79	079.png	0	t	bottom-left
80	080.png	0	t	bottom-right
81	081.png	0	t	bottom-center
82	082.png	0	t	bottom-left
83	083.png	0	t	bottom-right
84	084.png	0	t	bottom-right
85	085.png	0	t	bottom-left
86	086.png	0	t	bottom-left
87	087.png	0	t	bottom-right
88	088.png	0	t	bottom-right
89	089.png	0	t	top-left
90	090.png	0	t	bottom-left
91	091.png	0	t	top-right
92	092.png	0	t	bottom-left
93	093.png	0	t	bottom-right
94	094.png	0	t	center-center
95	095.png	0	t	center-right
96	096.png	0	t	center-center
97	097.png	0	t	center-center
98	098.png	0	t	center-center
99	099.png	0	t	center-center
100	100.png	0	t	center-center
101	101.png	0	t	center-right
102	102.png	0	t	bottom-center
103	103.png	0	t	center-right
104	104.png	0	t	bottom-center
105	105.png	0	t	center-center
106	106.png	0	t	center-center
107	107.png	0	t	bottom-right
108	108.png	0	t	center-center
109	109.png	0	t	center-center
110	110.png	0	t	center-center
111	111.png	0	t	bottom-right
112	112.png	0	t	bottom-left
113	113.png	0	t	center-right
114	114.png	0	t	bottom-center
115	115.png	0	t	bottom-center
116	116.png	0	t	center-left
117	117.png	0	t	center-center
118	118.png	0	t	center-center
119	119.png	0	t	bottom-center
120	120.png	0	t	bottom-center
121	121.png	0	t	top-right
122	122.png	0	t	center-center
123	123.png	0	t	bottom-right
124	124.png	0	t	top-left
125	125.png	0	t	top-left
126	126.png	0	t	bottom-left
127	127.png	0	t	bottom-center
128	128.png	0	t	bottom-right
129	129.png	0	t	bottom-center
130	130.png	0	t	bottom-center
131	131.png	0	t	bottom-right
132	132.png	0	t	bottom-right
133	133.png	0	t	bottom-center
134	001.webm	1	t	bottom-center
135	002.webm	1	f	top-left
136	003.webm	1	t	bottom-right
137	004.webm	1	t	center-center
138	005.webm	1	t	bottom-center
139	006.webm	1	f	top-left
140	007.webm	1	t	top-center
141	008.webm	1	f	top-left
142	009.webm	1	t	bottom-left
143	010.webm	1	t	center-center
144	011.webm	1	t	bottom-right
145	012.webm	1	t	bottom-right
146	013.webm	1	t	bottom-center
147	014.webm	1	t	bottom-center
148	015.webm	1	t	bottom-right
149	016.webm	1	t	bottom-center
\.


--
-- TOC entry 3415 (class 0 OID 16731)
-- Dependencies: 227
-- Data for Name: likes; Type: TABLE DATA; Schema: camagru_glagan; Owner: postgres
--

COPY camagru_glagan.likes (id, "user", image, at) FROM stdin;
1	4	1	2021-04-12 19:19:02+08
2	4	7	2021-04-12 19:19:30+08
3	4	15	2021-04-12 19:22:09+08
4	4	18	2021-04-12 19:22:22+08
5	4	22	2021-04-12 19:23:20+08
6	4	26	2021-04-12 19:23:38+08
7	4	25	2021-04-12 19:23:48+08
8	1	1	2021-04-12 19:58:03+08
9	1	3	2021-04-12 19:58:08+08
10	1	5	2021-04-12 19:58:10+08
11	1	6	2021-04-12 19:58:12+08
12	1	8	2021-04-12 19:58:14+08
13	1	10	2021-04-12 19:58:18+08
14	1	9	2021-04-12 19:58:21+08
15	1	15	2021-04-12 19:58:28+08
16	1	17	2021-04-12 19:58:33+08
17	1	18	2021-04-12 19:58:49+08
18	1	19	2021-04-12 19:58:53+08
19	1	21	2021-04-12 19:58:56+08
20	1	26	2021-04-12 19:59:01+08
21	1	25	2021-04-12 19:59:03+08
22	2	1	2021-04-12 19:59:05+08
23	2	2	2021-04-12 19:59:06+08
24	2	3	2021-04-12 19:59:08+08
25	2	5	2021-04-12 19:59:10+08
26	2	7	2021-04-12 19:59:13+08
27	2	8	2021-04-12 19:59:15+08
28	2	9	2021-04-12 19:59:17+08
29	2	10	2021-04-12 19:59:21+08
30	2	11	2021-04-12 19:59:23+08
31	2	13	2021-04-12 19:59:26+08
32	2	15	2021-04-12 19:59:28+08
33	2	17	2021-04-12 19:59:32+08
34	2	18	2021-04-12 19:59:35+08
35	2	20	2021-04-12 19:59:37+08
36	2	22	2021-04-12 19:59:39+08
37	2	23	2021-04-12 19:59:41+08
38	2	24	2021-04-12 19:59:43+08
39	2	25	2021-04-12 19:59:45+08
40	2	26	2021-04-12 19:59:47+08
41	3	2	2021-04-12 19:59:50+08
42	3	3	2021-04-12 19:59:51+08
43	3	4	2021-04-12 19:59:53+08
44	3	5	2021-04-12 19:59:59+08
45	3	6	2021-04-12 20:00:04+08
46	3	8	2021-04-12 20:00:07+08
47	3	9	2021-04-12 20:00:11+08
48	3	12	2021-04-12 20:00:16+08
49	3	13	2021-04-12 20:00:21+08
50	3	15	2021-04-12 20:00:25+08
51	3	16	2021-04-12 20:00:29+08
52	3	18	2021-04-12 20:02:47+08
53	3	19	2021-04-12 20:02:52+08
54	3	20	2021-04-12 20:03:01+08
55	3	21	2021-04-12 20:03:04+08
56	3	22	2021-04-12 20:03:06+08
57	3	23	2021-04-12 20:03:10+08
58	3	24	2021-04-12 20:03:12+08
59	3	25	2021-04-12 20:03:15+08
60	3	26	2021-04-12 20:03:19+08
61	2	19	2021-04-12 20:10:57+08
62	3	27	2021-04-12 20:13:44+08
63	3	17	2021-04-12 20:16:51+08
\.


--
-- TOC entry 3417 (class 0 OID 16737)
-- Dependencies: 229
-- Data for Name: users; Type: TABLE DATA; Schema: camagru_glagan; Owner: postgres
--

COPY camagru_glagan.users (id, username, email, password, verified, receivecomments) FROM stdin;
1	glagan	glagan@protonmail.com	$2y$10$44DLrdeD.03z4eiQyuyPAOXTnPIcdRStrEX7FmEtzPvc.wCu9UlSi	1	0
2	Anonymous	anon@mail.com	$2y$10$HS145gYyvu7XQVaYv.Gg../nkanMW8bjKsX98JHMiz2lujuqNsRMS	1	1
3	Martin	martin@gmail.com	$2y$10$h7dFlSJf7ZhbZ1aYU3Yfouqe54Nzrawu98MOq591aFZTnIYRy71Rm	1	1
4	Eva	eva.who@protonmail.ch	$2y$10$.oSQonligmFwa1X1kpioWezZ9YIRgGpXV2SkiHuM9Vzbhgut530N6	1	1
\.


--
-- TOC entry 3419 (class 0 OID 16746)
-- Dependencies: 231
-- Data for Name: usersessions; Type: TABLE DATA; Schema: camagru_glagan; Owner: postgres
--

COPY camagru_glagan.usersessions (id, usersid, session, issued, rememberme) FROM stdin;
\.


--
-- TOC entry 3421 (class 0 OID 16753)
-- Dependencies: 233
-- Data for Name: usertokens; Type: TABLE DATA; Schema: camagru_glagan; Owner: postgres
--

COPY camagru_glagan.usertokens (id, "user", token, scope, issued) FROM stdin;
\.


--
-- TOC entry 3434 (class 0 OID 0)
-- Dependencies: 220
-- Name: comments_id_seq; Type: SEQUENCE SET; Schema: camagru_glagan; Owner: postgres
--

SELECT pg_catalog.setval('camagru_glagan.comments_id_seq', 40, true);


--
-- TOC entry 3435 (class 0 OID 0)
-- Dependencies: 222
-- Name: creations_id_seq; Type: SEQUENCE SET; Schema: camagru_glagan; Owner: postgres
--

SELECT pg_catalog.setval('camagru_glagan.creations_id_seq', 27, true);


--
-- TOC entry 3436 (class 0 OID 0)
-- Dependencies: 224
-- Name: decorations_id_seq; Type: SEQUENCE SET; Schema: camagru_glagan; Owner: postgres
--

SELECT pg_catalog.setval('camagru_glagan.decorations_id_seq', 149, true);


--
-- TOC entry 3437 (class 0 OID 0)
-- Dependencies: 226
-- Name: likes_id_seq; Type: SEQUENCE SET; Schema: camagru_glagan; Owner: postgres
--

SELECT pg_catalog.setval('camagru_glagan.likes_id_seq', 63, true);


--
-- TOC entry 3438 (class 0 OID 0)
-- Dependencies: 228
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: camagru_glagan; Owner: postgres
--

SELECT pg_catalog.setval('camagru_glagan.users_id_seq', 34, true);


--
-- TOC entry 3439 (class 0 OID 0)
-- Dependencies: 230
-- Name: usersessions_id_seq; Type: SEQUENCE SET; Schema: camagru_glagan; Owner: postgres
--

SELECT pg_catalog.setval('camagru_glagan.usersessions_id_seq', 2, true);


--
-- TOC entry 3440 (class 0 OID 0)
-- Dependencies: 232
-- Name: usertokens_id_seq; Type: SEQUENCE SET; Schema: camagru_glagan; Owner: postgres
--

SELECT pg_catalog.setval('camagru_glagan.usertokens_id_seq', 1, true);


--
-- TOC entry 3238 (class 2606 OID 16783)
-- Name: comments idx_16708_primary; Type: CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.comments
    ADD CONSTRAINT idx_16708_primary PRIMARY KEY (id);


--
-- TOC entry 3241 (class 2606 OID 16781)
-- Name: creations idx_16716_primary; Type: CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.creations
    ADD CONSTRAINT idx_16716_primary PRIMARY KEY (id);


--
-- TOC entry 3244 (class 2606 OID 16779)
-- Name: decorations idx_16723_primary; Type: CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.decorations
    ADD CONSTRAINT idx_16723_primary PRIMARY KEY (id);


--
-- TOC entry 3247 (class 2606 OID 16780)
-- Name: likes idx_16731_primary; Type: CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.likes
    ADD CONSTRAINT idx_16731_primary PRIMARY KEY (id);


--
-- TOC entry 3251 (class 2606 OID 16784)
-- Name: users idx_16737_primary; Type: CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.users
    ADD CONSTRAINT idx_16737_primary PRIMARY KEY (id);


--
-- TOC entry 3254 (class 2606 OID 16782)
-- Name: usersessions idx_16746_primary; Type: CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.usersessions
    ADD CONSTRAINT idx_16746_primary PRIMARY KEY (id);


--
-- TOC entry 3257 (class 2606 OID 16785)
-- Name: usertokens idx_16753_primary; Type: CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.usertokens
    ADD CONSTRAINT idx_16753_primary PRIMARY KEY (id);


--
-- TOC entry 3236 (class 1259 OID 16766)
-- Name: idx_16708_image; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE INDEX idx_16708_image ON camagru_glagan.comments USING btree (image);


--
-- TOC entry 3239 (class 1259 OID 16768)
-- Name: idx_16708_user; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE INDEX idx_16708_user ON camagru_glagan.comments USING btree ("user");


--
-- TOC entry 3242 (class 1259 OID 16763)
-- Name: idx_16716_user; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE INDEX idx_16716_user ON camagru_glagan.creations USING btree ("user");


--
-- TOC entry 3245 (class 1259 OID 16759)
-- Name: idx_16731_image; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE INDEX idx_16731_image ON camagru_glagan.likes USING btree (image);


--
-- TOC entry 3248 (class 1259 OID 16761)
-- Name: idx_16731_user; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE INDEX idx_16731_user ON camagru_glagan.likes USING btree ("user");


--
-- TOC entry 3249 (class 1259 OID 16769)
-- Name: idx_16737_mail; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE UNIQUE INDEX idx_16737_mail ON camagru_glagan.users USING btree (email);


--
-- TOC entry 3252 (class 1259 OID 16771)
-- Name: idx_16737_username; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE UNIQUE INDEX idx_16737_username ON camagru_glagan.users USING btree (username);


--
-- TOC entry 3255 (class 1259 OID 16765)
-- Name: idx_16746_user; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE INDEX idx_16746_user ON camagru_glagan.usersessions USING btree (usersid);


--
-- TOC entry 3258 (class 1259 OID 16773)
-- Name: idx_16753_user; Type: INDEX; Schema: camagru_glagan; Owner: postgres
--

CREATE INDEX idx_16753_user ON camagru_glagan.usertokens USING btree ("user");


--
-- TOC entry 3259 (class 2606 OID 16786)
-- Name: comments comments_ibfk_1; Type: FK CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.comments
    ADD CONSTRAINT comments_ibfk_1 FOREIGN KEY (image) REFERENCES camagru_glagan.creations(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- TOC entry 3260 (class 2606 OID 16791)
-- Name: comments comments_ibfk_2; Type: FK CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.comments
    ADD CONSTRAINT comments_ibfk_2 FOREIGN KEY ("user") REFERENCES camagru_glagan.users(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- TOC entry 3261 (class 2606 OID 16796)
-- Name: creations creations_ibfk_1; Type: FK CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.creations
    ADD CONSTRAINT creations_ibfk_1 FOREIGN KEY ("user") REFERENCES camagru_glagan.users(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- TOC entry 3262 (class 2606 OID 16801)
-- Name: likes likes_ibfk_1; Type: FK CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.likes
    ADD CONSTRAINT likes_ibfk_1 FOREIGN KEY (image) REFERENCES camagru_glagan.creations(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- TOC entry 3263 (class 2606 OID 16806)
-- Name: likes likes_ibfk_2; Type: FK CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.likes
    ADD CONSTRAINT likes_ibfk_2 FOREIGN KEY ("user") REFERENCES camagru_glagan.users(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- TOC entry 3264 (class 2606 OID 16811)
-- Name: usersessions usersessions_ibfk_1; Type: FK CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.usersessions
    ADD CONSTRAINT usersessions_ibfk_1 FOREIGN KEY (usersid) REFERENCES camagru_glagan.users(id) ON UPDATE RESTRICT ON DELETE CASCADE;


--
-- TOC entry 3265 (class 2606 OID 16816)
-- Name: usertokens usertokens_ibfk_1; Type: FK CONSTRAINT; Schema: camagru_glagan; Owner: postgres
--

ALTER TABLE ONLY camagru_glagan.usertokens
    ADD CONSTRAINT usertokens_ibfk_1 FOREIGN KEY ("user") REFERENCES camagru_glagan.users(id) ON UPDATE RESTRICT ON DELETE CASCADE;


-- Completed on 2023-02-23 19:01:58

--
-- PostgreSQL database dump complete
--


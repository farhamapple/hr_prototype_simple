--
-- PostgreSQL database dump
--

\restrict U6UgjOIl2PPVU2uc12v4ciLZuh07ZtfyXuhrh3nGtTLgfrSMWKXGbLlbwMFj3Lz

-- Dumped from database version 16.14
-- Dumped by pg_dump version 18.3 (Ubuntu 18.3-1.pgdg24.04+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO postgres;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS '';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: countries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.countries (
    country_id character varying(2) NOT NULL,
    country_name character varying(40) DEFAULT NULL::character varying,
    region_id integer
);


ALTER TABLE public.countries OWNER TO postgres;

--
-- Name: departments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.departments (
    department_id integer DEFAULT 0 NOT NULL,
    department_name character varying(30) NOT NULL,
    manager_id integer,
    location_id integer
);


ALTER TABLE public.departments OWNER TO postgres;

--
-- Name: employees; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employees (
    employee_id integer DEFAULT 0 NOT NULL,
    first_name character varying(20) DEFAULT NULL::character varying,
    last_name character varying(25) NOT NULL,
    email character varying(25) NOT NULL,
    phone_number character varying(20) DEFAULT NULL::character varying,
    hire_date date NOT NULL,
    job_id character varying(10) NOT NULL,
    salary numeric(8,2) DEFAULT NULL::numeric,
    commission_pct numeric(2,2) DEFAULT NULL::numeric,
    manager_id integer,
    department_id integer
);


ALTER TABLE public.employees OWNER TO postgres;

--
-- Name: job_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_history (
    employee_id integer NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    job_id character varying(10) NOT NULL,
    department_id integer
);


ALTER TABLE public.job_history OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    job_id character varying(10) DEFAULT ''::character varying NOT NULL,
    job_title character varying(35) NOT NULL,
    min_salary integer,
    max_salary integer
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: locations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.locations (
    location_id integer DEFAULT 0 NOT NULL,
    street_address character varying(40) DEFAULT NULL::character varying,
    postal_code character varying(12) DEFAULT NULL::character varying,
    city character varying(30) NOT NULL,
    state_province character varying(25) DEFAULT NULL::character varying,
    country_id character varying(2) DEFAULT NULL::character varying
);


ALTER TABLE public.locations OWNER TO postgres;

--
-- Name: regions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.regions (
    region_id integer NOT NULL,
    region_name character varying(25) DEFAULT NULL::character varying
);


ALTER TABLE public.regions OWNER TO postgres;

--
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.countries (country_id, country_name, region_id) FROM stdin;
AR	Argentina	2
AU	Australia	3
BE	Belgium	1
BR	Brazil	2
CA	Canada	2
CH	Switzerland	1
CN	China	3
DE	Germany	1
DK	Denmark	1
EG	Egypt	4
FR	France	1
HK	HongKong	3
IL	Israel	4
IN	India	3
IT	Italy	1
JP	Japan	3
KW	Kuwait	4
MX	Mexico	2
NG	Nigeria	4
NL	Netherlands	1
SG	Singapore	3
UK	United Kingdom	1
US	United States of America	2
ZM	Zambia	4
ZW	Zimbabwe	4
\.


--
-- Data for Name: departments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.departments (department_id, department_name, manager_id, location_id) FROM stdin;
10	Administration	200	1700
20	Marketing	201	1800
30	Purchasing	114	1700
40	Human Resources	203	2400
50	Shipping	121	1500
60	IT	103	1400
70	Public Relations	204	2700
80	Sales	145	2500
90	Executive	100	1700
100	Finance	108	1700
110	Accounting	205	1700
120	Treasury	\N	1700
130	Corporate Tax	\N	1700
140	Control And Credit	\N	1700
150	Shareholder Services	\N	1700
160	Benefits	\N	1700
170	Manufacturing	\N	1700
180	Construction	\N	1700
190	Contracting	\N	1700
200	Operations	\N	1700
210	IT Support	\N	1700
220	NOC	\N	1700
230	IT Helpdesk	\N	1700
240	Government Sales	\N	1700
250	Retail Sales	\N	1700
260	Recruiting	\N	1700
270	Payroll	\N	1700
\.


--
-- Data for Name: employees; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employees (employee_id, first_name, last_name, email, phone_number, hire_date, job_id, salary, commission_pct, manager_id, department_id) FROM stdin;
100	Steven	King	SKING	515.123.4567	1987-06-17	AD_PRES	24000.00	0.00	\N	90
101	Neena	Kochhar	NKOCHHAR	515.123.4568	1987-06-18	AD_VP	17000.00	0.00	100	90
102	Lex	De Haan	LDEHAAN	515.123.4569	1987-06-19	AD_VP	17000.00	0.00	100	90
103	Alexander	Hunold	AHUNOLD	590.423.4567	1987-06-20	IT_PROG	9000.00	0.00	102	60
104	Bruce	Ernst	BERNST	590.423.4568	1987-06-21	IT_PROG	6000.00	0.00	103	60
105	David	Austin	DAUSTIN	590.423.4569	1987-06-22	IT_PROG	4800.00	0.00	103	60
106	Valli	Pataballa	VPATABAL	590.423.4560	1987-06-23	IT_PROG	4800.00	0.00	103	60
107	Diana	Lorentz	DLORENTZ	590.423.5567	1987-06-24	IT_PROG	4200.00	0.00	103	60
108	Nancy	Greenberg	NGREENBE	515.124.4569	1987-06-25	FI_MGR	12000.00	0.00	101	100
109	Daniel	Faviet	DFAVIET	515.124.4169	1987-06-26	FI_ACCOUNT	9000.00	0.00	108	100
110	John	Chen	JCHEN	515.124.4269	1987-06-27	FI_ACCOUNT	8200.00	0.00	108	100
111	Ismael	Sciarra	ISCIARRA	515.124.4369	1987-06-28	FI_ACCOUNT	7700.00	0.00	108	100
112	Jose Manuel	Urman	JMURMAN	515.124.4469	1987-06-29	FI_ACCOUNT	7800.00	0.00	108	100
113	Luis	Popp	LPOPP	515.124.4567	1987-06-30	FI_ACCOUNT	6900.00	0.00	108	100
114	Den	Raphaely	DRAPHEAL	515.127.4561	1987-07-01	PU_MAN	11000.00	0.00	100	30
115	Alexander	Khoo	AKHOO	515.127.4562	1987-07-02	PU_CLERK	3100.00	0.00	114	30
116	Shelli	Baida	SBAIDA	515.127.4563	1987-07-03	PU_CLERK	2900.00	0.00	114	30
117	Sigal	Tobias	STOBIAS	515.127.4564	1987-07-04	PU_CLERK	2800.00	0.00	114	30
118	Guy	Himuro	GHIMURO	515.127.4565	1987-07-05	PU_CLERK	2600.00	0.00	114	30
119	Karen	Colmenares	KCOLMENA	515.127.4566	1987-07-06	PU_CLERK	2500.00	0.00	114	30
120	Matthew	Weiss	MWEISS	650.123.1234	1987-07-07	ST_MAN	8000.00	0.00	100	50
121	Adam	Fripp	AFRIPP	650.123.2234	1987-07-08	ST_MAN	8200.00	0.00	100	50
122	Payam	Kaufling	PKAUFLIN	650.123.3234	1987-07-09	ST_MAN	7900.00	0.00	100	50
123	Shanta	Vollman	SVOLLMAN	650.123.4234	1987-07-10	ST_MAN	6500.00	0.00	100	50
124	Kevin	Mourgos	KMOURGOS	650.123.5234	1987-07-11	ST_MAN	5800.00	0.00	100	50
125	Julia	Nayer	JNAYER	650.124.1214	1987-07-12	ST_CLERK	3200.00	0.00	120	50
126	Irene	Mikkilineni	IMIKKILI	650.124.1224	1987-07-13	ST_CLERK	2700.00	0.00	120	50
127	James	Landry	JLANDRY	650.124.1334	1987-07-14	ST_CLERK	2400.00	0.00	120	50
128	Steven	Markle	SMARKLE	650.124.1434	1987-07-15	ST_CLERK	2200.00	0.00	120	50
129	Laura	Bissot	LBISSOT	650.124.5234	1987-07-16	ST_CLERK	3300.00	0.00	121	50
130	Mozhe	Atkinson	MATKINSO	650.124.6234	1987-07-17	ST_CLERK	2800.00	0.00	121	50
131	James	Marlow	JAMRLOW	650.124.7234	1987-07-18	ST_CLERK	2500.00	0.00	121	50
132	TJ	Olson	TJOLSON	650.124.8234	1987-07-19	ST_CLERK	2100.00	0.00	121	50
133	Jason	Mallin	JMALLIN	650.127.1934	1987-07-20	ST_CLERK	3300.00	0.00	122	50
134	Michael	Rogers	MROGERS	650.127.1834	1987-07-21	ST_CLERK	2900.00	0.00	122	50
135	Ki	Gee	KGEE	650.127.1734	1987-07-22	ST_CLERK	2400.00	0.00	122	50
136	Hazel	Philtanker	HPHILTAN	650.127.1634	1987-07-23	ST_CLERK	2200.00	0.00	122	50
137	Renske	Ladwig	RLADWIG	650.121.1234	1987-07-24	ST_CLERK	3600.00	0.00	123	50
138	Stephen	Stiles	SSTILES	650.121.2034	1987-07-25	ST_CLERK	3200.00	0.00	123	50
139	John	Seo	JSEO	650.121.2019	1987-07-26	ST_CLERK	2700.00	0.00	123	50
140	Joshua	Patel	JPATEL	650.121.1834	1987-07-27	ST_CLERK	2500.00	0.00	123	50
141	Trenna	Rajs	TRAJS	650.121.8009	1987-07-28	ST_CLERK	3500.00	0.00	124	50
142	Curtis	Davies	CDAVIES	650.121.2994	1987-07-29	ST_CLERK	3100.00	0.00	124	50
143	Randall	Matos	RMATOS	650.121.2874	1987-07-30	ST_CLERK	2600.00	0.00	124	50
144	Peter	Vargas	PVARGAS	650.121.2004	1987-07-31	ST_CLERK	2500.00	0.00	124	50
145	John	Russell	JRUSSEL	011.44.1344.429268	1987-08-01	SA_MAN	14000.00	0.40	100	80
146	Karen	Partners	KPARTNER	011.44.1344.467268	1987-08-02	SA_MAN	13500.00	0.30	100	80
147	Alberto	Errazuriz	AERRAZUR	011.44.1344.429278	1987-08-03	SA_MAN	12000.00	0.30	100	80
148	Gerald	Cambrault	GCAMBRAU	011.44.1344.619268	1987-08-04	SA_MAN	11000.00	0.30	100	80
149	Eleni	Zlotkey	EZLOTKEY	011.44.1344.429018	1987-08-05	SA_MAN	10500.00	0.20	100	80
150	Peter	Tucker	PTUCKER	011.44.1344.129268	1987-08-06	SA_REP	10000.00	0.30	145	80
151	David	Bernstein	DBERNSTE	011.44.1344.345268	1987-08-07	SA_REP	9500.00	0.25	145	80
152	Peter	Hall	PHALL	011.44.1344.478968	1987-08-08	SA_REP	9000.00	0.25	145	80
153	Christopher	Olsen	COLSEN	011.44.1344.498718	1987-08-09	SA_REP	8000.00	0.20	145	80
154	Nanette	Cambrault	NCAMBRAU	011.44.1344.987668	1987-08-10	SA_REP	7500.00	0.20	145	80
155	Oliver	Tuvault	OTUVAULT	011.44.1344.486508	1987-08-11	SA_REP	7000.00	0.15	145	80
156	Janette	King	JKING	011.44.1345.429268	1987-08-12	SA_REP	10000.00	0.35	146	80
157	Patrick	Sully	PSULLY	011.44.1345.929268	1987-08-13	SA_REP	9500.00	0.35	146	80
158	Allan	McEwen	AMCEWEN	011.44.1345.829268	1987-08-14	SA_REP	9000.00	0.35	146	80
159	Lindsey	Smith	LSMITH	011.44.1345.729268	1987-08-15	SA_REP	8000.00	0.30	146	80
160	Louise	Doran	LDORAN	011.44.1345.629268	1987-08-16	SA_REP	7500.00	0.30	146	80
161	Sarath	Sewall	SSEWALL	011.44.1345.529268	1987-08-17	SA_REP	7000.00	0.25	146	80
162	Clara	Vishney	CVISHNEY	011.44.1346.129268	1987-08-18	SA_REP	10500.00	0.25	147	80
163	Danielle	Greene	DGREENE	011.44.1346.229268	1987-08-19	SA_REP	9500.00	0.15	147	80
164	Mattea	Marvins	MMARVINS	011.44.1346.329268	1987-08-20	SA_REP	7200.00	0.10	147	80
165	David	Lee	DLEE	011.44.1346.529268	1987-08-21	SA_REP	6800.00	0.10	147	80
166	Sundar	Ande	SANDE	011.44.1346.629268	1987-08-22	SA_REP	6400.00	0.10	147	80
167	Amit	Banda	ABANDA	011.44.1346.729268	1987-08-23	SA_REP	6200.00	0.10	147	80
168	Lisa	Ozer	LOZER	011.44.1343.929268	1987-08-24	SA_REP	11500.00	0.25	148	80
169	Harrison	Bloom	HBLOOM	011.44.1343.829268	1987-08-25	SA_REP	10000.00	0.20	148	80
170	Tayler	Fox	TFOX	011.44.1343.729268	1987-08-26	SA_REP	9600.00	0.20	148	80
171	William	Smith	WSMITH	011.44.1343.629268	1987-08-27	SA_REP	7400.00	0.15	148	80
172	Elizabeth	Bates	EBATES	011.44.1343.529268	1987-08-28	SA_REP	7300.00	0.15	148	80
173	Sundita	Kumar	SKUMAR	011.44.1343.329268	1987-08-29	SA_REP	6100.00	0.10	148	80
174	Ellen	Abel	EABEL	011.44.1644.429267	1987-08-30	SA_REP	11000.00	0.30	149	80
175	Alyssa	Hutton	AHUTTON	011.44.1644.429266	1987-08-31	SA_REP	8800.00	0.25	149	80
176	Jonathon	Taylor	JTAYLOR	011.44.1644.429265	1987-09-01	SA_REP	8600.00	0.20	149	80
177	Jack	Livingston	JLIVINGS	011.44.1644.429264	1987-09-02	SA_REP	8400.00	0.20	149	80
178	Kimberely	Grant	KGRANT	011.44.1644.429263	1987-09-03	SA_REP	7000.00	0.15	149	80
179	Charles	Johnson	CJOHNSON	011.44.1644.429262	1987-09-04	SA_REP	6200.00	0.10	149	80
180	Winston	Taylor	WTAYLOR	650.507.9876	1987-09-05	SH_CLERK	3200.00	0.00	120	50
181	Jean	Fleaur	JFLEAUR	650.507.9877	1987-09-06	SH_CLERK	3100.00	0.00	120	50
182	Martha	Sullivan	MSULLIVA	650.507.9878	1987-09-07	SH_CLERK	2500.00	0.00	120	50
183	Girard	Geoni	GGEONI	650.507.9879	1987-09-08	SH_CLERK	2800.00	0.00	120	50
184	Nandita	Sarchand	NSARCHAN	650.509.1876	1987-09-09	SH_CLERK	4200.00	0.00	121	50
185	Alexis	Bull	ABULL	650.509.2876	1987-09-10	SH_CLERK	4100.00	0.00	121	50
186	Julia	Dellinger	JDELLING	650.509.3876	1987-09-11	SH_CLERK	3400.00	0.00	121	50
187	Anthony	Cabrio	ACABRIO	650.509.4876	1987-09-12	SH_CLERK	3000.00	0.00	121	50
188	Kelly	Chung	KCHUNG	650.505.1876	1987-09-13	SH_CLERK	3800.00	0.00	122	50
189	Jennifer	Dilly	JDILLY	650.505.2876	1987-09-14	SH_CLERK	3600.00	0.00	122	50
190	Timothy	Gates	TGATES	650.505.3876	1987-09-15	SH_CLERK	2900.00	0.00	122	50
191	Randall	Perkins	RPERKINS	650.505.4876	1987-09-16	SH_CLERK	2500.00	0.00	122	50
192	Sarah	Bell	SBELL	650.501.1876	1987-09-17	SH_CLERK	4000.00	0.00	123	50
193	Britney	Everett	BEVERETT	650.501.2876	1987-09-18	SH_CLERK	3900.00	0.00	123	50
194	Samuel	McCain	SMCCAIN	650.501.3876	1987-09-19	SH_CLERK	3200.00	0.00	123	50
195	Vance	Jones	VJONES	650.501.4876	1987-09-20	SH_CLERK	2800.00	0.00	123	50
196	Alana	Walsh	AWALSH	650.507.9811	1987-09-21	SH_CLERK	3100.00	0.00	124	50
197	Kevin	Feeney	KFEENEY	650.507.9822	1987-09-22	SH_CLERK	3000.00	0.00	124	50
198	Donald	OConnell	DOCONNEL	650.507.9833	1987-09-23	SH_CLERK	2600.00	0.00	124	50
199	Douglas	Grant	DGRANT	650.507.9844	1987-09-24	SH_CLERK	2600.00	0.00	124	50
200	Jennifer	Whalen	JWHALEN	515.123.4444	1987-09-25	AD_ASST	4400.00	0.00	101	10
201	Michael	Hartstein	MHARTSTE	515.123.5555	1987-09-26	MK_MAN	13000.00	0.00	100	20
202	Pat	Fay	PFAY	603.123.6666	1987-09-27	MK_REP	6000.00	0.00	201	20
203	Susan	Mavris	SMAVRIS	515.123.7777	1987-09-28	HR_REP	6500.00	0.00	101	40
204	Hermann	Baer	HBAER	515.123.8888	1987-09-29	PR_REP	10000.00	0.00	101	70
205	Shelley	Higgins	SHIGGINS	515.123.8080	1987-09-30	AC_MGR	12000.00	0.00	101	110
206	William	Gietz	WGIETZ	515.123.8181	1987-10-01	AC_ACCOUNT	8300.00	0.00	205	110
\.


--
-- Data for Name: job_history; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_history (employee_id, start_date, end_date, job_id, department_id) FROM stdin;
102	1993-01-13	1998-07-24	IT_PROG	60
101	1989-09-21	1993-10-27	AC_ACCOUNT	110
101	1993-10-28	1997-03-15	AC_MGR	110
201	1996-02-17	1999-12-19	MK_REP	20
114	1998-03-24	1999-12-31	ST_CLERK	50
122	1999-01-01	1999-12-31	ST_CLERK	50
200	1987-09-17	1993-06-17	AD_ASST	90
176	1998-03-24	1998-12-31	SA_REP	80
176	1999-01-01	1999-12-31	SA_MAN	80
200	1994-07-01	1998-12-31	AC_ACCOUNT	90
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (job_id, job_title, min_salary, max_salary) FROM stdin;
AD_PRES	President	20000	40000
AD_VP	Administration Vice President	15000	30000
AD_ASST	Administration Assistant	3000	6000
FI_MGR	Finance Manager	8200	16000
FI_ACCOUNT	Accountant	4200	9000
AC_MGR	Accounting Manager	8200	16000
AC_ACCOUNT	Public Accountant	4200	9000
SA_MAN	Sales Manager	10000	20000
SA_REP	Sales Representative	6000	12000
PU_MAN	Purchasing Manager	8000	15000
PU_CLERK	Purchasing Clerk	2500	5500
ST_MAN	Stock Manager	5500	8500
ST_CLERK	Stock Clerk	2000	5000
SH_CLERK	Shipping Clerk	2500	5500
IT_PROG	Programmer	4000	10000
MK_MAN	Marketing Manager	9000	15000
MK_REP	Marketing Representative	4000	9000
HR_REP	Human Resources Representative	4000	9000
PR_REP	Public Relations Representative	4500	10500
\.


--
-- Data for Name: locations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.locations (location_id, street_address, postal_code, city, state_province, country_id) FROM stdin;
1000	1297 Via Cola di Rie	989	Roma		IT
1100	93091 Calle della Testa	10934	Venice		IT
1200	2017 Shinjuku-ku	1689	Tokyo	Tokyo Prefecture	JP
1300	9450 Kamiya-cho	6823	Hiroshima		JP
1400	2014 Jabberwocky Rd	26192	Southlake	Texas	US
1500	2011 Interiors Blvd	99236	South San Francisco	California	US
1600	2007 Zagora St	50090	South Brunswick	New Jersey	US
1700	2004 Charade Rd	98199	Seattle	Washington	US
1800	147 Spadina Ave	M5V 2L7	Toronto	Ontario	CA
1900	6092 Boxwood St	YSW 9T2	Whitehorse	Yukon	CA
2000	40-5-12 Laogianggen	190518	Beijing		CN
2100	1298 Vileparle (E)	490231	Bombay	Maharashtra	IN
2200	12-98 Victoria Street	2901	Sydney	New South Wales	AU
2300	198 Clementi North	540198	Singapore		SG
2400	8204 Arthur St		London		UK
2500	Magdalen Centre, The Oxford Science Park	OX9 9ZB	Oxford	Oxford	UK
2600	9702 Chester Road	9629850293	Stretford	Manchester	UK
2700	Schwanthalerstr. 7031	80925	Munich	Bavaria	DE
2800	Rua Frei Caneca 1360	01307-002	Sao Paulo	Sao Paulo	BR
2900	20 Rue des Corps-Saints	1730	Geneva	Geneve	CH
3000	Murtenstrasse 921	3095	Bern	BE	CH
3100	Pieter Breughelstraat 837	3029SK	Utrecht	Utrecht	NL
3200	Mariano Escobedo 9991	11932	Mexico City	Distrito Federal	MX
\.


--
-- Data for Name: regions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.regions (region_id, region_name) FROM stdin;
1	Europe
2	Americas
3	Asia
4	Middle East and Africa
\.


--
-- Name: countries countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (country_id);


--
-- Name: departments departments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT departments_pkey PRIMARY KEY (department_id);


--
-- Name: employees emp_email_uk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT emp_email_uk UNIQUE (email);


--
-- Name: employees employees_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_pkey PRIMARY KEY (employee_id);


--
-- Name: job_history job_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_history
    ADD CONSTRAINT job_history_pkey PRIMARY KEY (employee_id, start_date);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (job_id);


--
-- Name: locations locations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.locations
    ADD CONSTRAINT locations_pkey PRIMARY KEY (location_id);


--
-- Name: regions regions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.regions
    ADD CONSTRAINT regions_pkey PRIMARY KEY (region_id);


--
-- Name: regions sss; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.regions
    ADD CONSTRAINT sss UNIQUE (region_name);


--
-- Name: countries_region_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX countries_region_id_idx ON public.countries USING btree (region_id);


--
-- Name: departments_location_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX departments_location_id_idx ON public.departments USING btree (location_id);


--
-- Name: departments_manager_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX departments_manager_id_idx ON public.departments USING btree (manager_id);


--
-- Name: employees_department_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX employees_department_id_idx ON public.employees USING btree (department_id);


--
-- Name: employees_job_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX employees_job_id_idx ON public.employees USING btree (job_id);


--
-- Name: employees_manager_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX employees_manager_id_idx ON public.employees USING btree (manager_id);


--
-- Name: employees_name_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX employees_name_idx ON public.employees USING btree (last_name, first_name);


--
-- Name: job_history_department_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX job_history_department_id_idx ON public.job_history USING btree (department_id);


--
-- Name: job_history_employee_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX job_history_employee_id_idx ON public.job_history USING btree (employee_id);


--
-- Name: job_history_job_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX job_history_job_id_idx ON public.job_history USING btree (job_id);


--
-- Name: locations_city_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX locations_city_idx ON public.locations USING btree (city);


--
-- Name: locations_country_id_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX locations_country_id_idx ON public.locations USING btree (country_id);


--
-- Name: locations_state_province_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX locations_state_province_idx ON public.locations USING btree (state_province);


--
-- Name: countries countr_reg_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.countries
    ADD CONSTRAINT countr_reg_fk FOREIGN KEY (region_id) REFERENCES public.regions(region_id);


--
-- Name: departments dept_location_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT dept_location_fk FOREIGN KEY (location_id) REFERENCES public.locations(location_id);


--
-- Name: departments dept_mgr_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.departments
    ADD CONSTRAINT dept_mgr_fk FOREIGN KEY (manager_id) REFERENCES public.employees(employee_id);


--
-- Name: employees emp_department_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT emp_department_fk FOREIGN KEY (department_id) REFERENCES public.departments(department_id);


--
-- Name: employees emp_job_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT emp_job_fk FOREIGN KEY (job_id) REFERENCES public.jobs(job_id);


--
-- Name: employees emp_manager_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT emp_manager_fk FOREIGN KEY (manager_id) REFERENCES public.employees(employee_id);


--
-- Name: job_history jhist_department_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_history
    ADD CONSTRAINT jhist_department_fk FOREIGN KEY (department_id) REFERENCES public.departments(department_id);


--
-- Name: job_history jhist_employee_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_history
    ADD CONSTRAINT jhist_employee_fk FOREIGN KEY (employee_id) REFERENCES public.employees(employee_id);


--
-- Name: job_history jhist_job_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_history
    ADD CONSTRAINT jhist_job_fk FOREIGN KEY (job_id) REFERENCES public.jobs(job_id);


--
-- Name: locations loc_country_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.locations
    ADD CONSTRAINT loc_country_fk FOREIGN KEY (country_id) REFERENCES public.countries(country_id);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;


--
-- PostgreSQL database dump complete
--

\unrestrict U6UgjOIl2PPVU2uc12v4ciLZuh07ZtfyXuhrh3nGtTLgfrSMWKXGbLlbwMFj3Lz


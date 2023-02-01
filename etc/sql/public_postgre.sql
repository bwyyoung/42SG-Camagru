--
-- PostgreSQL database dump
--

-- Dumped from database version 15.1
-- Dumped by pg_dump version 15.1

-- Started on 2023-02-01 16:02:18

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
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 3357 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 219 (class 1259 OID 16399)
-- Name: login_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.login_user (
    id integer NOT NULL,
    name character varying(60) NOT NULL,
    user_name character varying(20) NOT NULL,
    password character varying(20) NOT NULL
);


ALTER TABLE public.login_user OWNER TO postgres;

--
-- TOC entry 3351 (class 0 OID 16399)
-- Dependencies: 219
-- Data for Name: login_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.login_user (id, name, user_name, password) FROM stdin;
\.


-- Completed on 2023-02-01 16:02:18

--
-- PostgreSQL database dump complete
--


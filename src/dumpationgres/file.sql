--
-- PostgreSQL database dump
--

-- Dumped from database version 16.4
-- Dumped by pg_dump version 16.4

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: joueurs; Type: TABLE; Schema: public; Owner: -
--

DROP TABLE IF EXISTS public.joueurs;

CREATE TABLE public.joueurs (
    id integer NOT NULL,
    nom character varying(50) NOT NULL,
    prenom character varying(50) NOT NULL,
    age integer,
    score integer DEFAULT 0,
    date_creation timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


--
-- Name: joueurs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.joueurs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: joueurs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.joueurs_id_seq OWNED BY public.joueurs.id;


--
-- Name: joueurs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.joueurs ALTER COLUMN id SET DEFAULT nextval('public.joueurs_id_seq'::regclass);


--
-- Data for Name: joueurs; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.joueurs (id, nom, prenom, age, score, date_creation) FROM stdin;
1	Mbappe	Kylian	25	50	2024-09-09 10:07:49.367593
2	Ronaldo	Cristiano	38	200	2024-09-09 10:07:49.367593
3	Messi	Lionel	36	180	2024-09-09 10:07:49.367593
\.


--
-- Name: joueurs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.joueurs_id_seq', 3, true);


--
-- Name: joueurs joueurs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.joueurs
    ADD CONSTRAINT joueurs_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--


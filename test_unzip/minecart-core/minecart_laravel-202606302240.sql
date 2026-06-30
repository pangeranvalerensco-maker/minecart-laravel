--
-- PostgreSQL database dump
--

\restrict fROByPk3bqNjTdA6ZHDt2V8V8h7lA9PhSSkaqRaqbvF3QFzw7V2NIfkbGZEQO0g

-- Dumped from database version 18.2
-- Dumped by pg_dump version 18.2

-- Started on 2026-06-30 22:40:59

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
-- TOC entry 5284 (class 1262 OID 65702)
-- Name: minecart_laravel; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE minecart_laravel WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_Indonesia.1252';


ALTER DATABASE minecart_laravel OWNER TO postgres;

\unrestrict fROByPk3bqNjTdA6ZHDt2V8V8h7lA9PhSSkaqRaqbvF3QFzw7V2NIfkbGZEQO0g
\connect minecart_laravel
\restrict fROByPk3bqNjTdA6ZHDt2V8V8h7lA9PhSSkaqRaqbvF3QFzw7V2NIfkbGZEQO0g

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 225 (class 1259 OID 67255)
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 67266)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 67327)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    name character varying(100) NOT NULL,
    slug character varying(100) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 67326)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- TOC entry 5285 (class 0 OID 0)
-- Dependencies: 232
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 245 (class 1259 OID 67487)
-- Name: conversations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.conversations (
    id bigint NOT NULL,
    buyer_id bigint NOT NULL,
    seller_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.conversations OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 67486)
-- Name: conversations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.conversations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.conversations_id_seq OWNER TO postgres;

--
-- TOC entry 5286 (class 0 OID 0)
-- Dependencies: 244
-- Name: conversations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.conversations_id_seq OWNED BY public.conversations.id;


--
-- TOC entry 251 (class 1259 OID 67556)
-- Name: coupons; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.coupons (
    id bigint NOT NULL,
    code character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    value bigint NOT NULL,
    min_purchase bigint DEFAULT '0'::bigint NOT NULL,
    max_discount bigint,
    usage_limit integer,
    used_count integer DEFAULT 0 NOT NULL,
    valid_from timestamp(0) without time zone,
    valid_until timestamp(0) without time zone,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT coupons_type_check CHECK (((type)::text = ANY ((ARRAY['percent'::character varying, 'fixed'::character varying])::text[])))
);


ALTER TABLE public.coupons OWNER TO postgres;

--
-- TOC entry 250 (class 1259 OID 67555)
-- Name: coupons_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.coupons_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.coupons_id_seq OWNER TO postgres;

--
-- TOC entry 5287 (class 0 OID 0)
-- Dependencies: 250
-- Name: coupons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.coupons_id_seq OWNED BY public.coupons.id;


--
-- TOC entry 231 (class 1259 OID 67308)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 67307)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5288 (class 0 OID 0)
-- Dependencies: 230
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 229 (class 1259 OID 67293)
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 67278)
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 67277)
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- TOC entry 5289 (class 0 OID 0)
-- Dependencies: 227
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- TOC entry 247 (class 1259 OID 67509)
-- Name: messages; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.messages (
    id bigint NOT NULL,
    conversation_id bigint NOT NULL,
    sender_id bigint NOT NULL,
    message text NOT NULL,
    is_read boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.messages OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 67508)
-- Name: messages_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.messages_id_seq OWNER TO postgres;

--
-- TOC entry 5290 (class 0 OID 0)
-- Dependencies: 246
-- Name: messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.messages_id_seq OWNED BY public.messages.id;


--
-- TOC entry 220 (class 1259 OID 67210)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 67209)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 5291 (class 0 OID 0)
-- Dependencies: 219
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 239 (class 1259 OID 67391)
-- Name: order_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_items (
    id bigint NOT NULL,
    order_id bigint NOT NULL,
    product_id bigint,
    product_name character varying(255) NOT NULL,
    price bigint NOT NULL,
    quantity integer NOT NULL,
    subtotal bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    tracking_number character varying(255),
    shipping_courier character varying(255),
    status character varying(255) DEFAULT 'processing'::character varying NOT NULL
);


ALTER TABLE public.order_items OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 67390)
-- Name: order_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.order_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.order_items_id_seq OWNER TO postgres;

--
-- TOC entry 5292 (class 0 OID 0)
-- Dependencies: 238
-- Name: order_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.order_items_id_seq OWNED BY public.order_items.id;


--
-- TOC entry 237 (class 1259 OID 67365)
-- Name: orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orders (
    id bigint NOT NULL,
    order_number character varying(255) NOT NULL,
    fullname character varying(255) NOT NULL,
    phone character varying(255) NOT NULL,
    address text NOT NULL,
    city character varying(255) NOT NULL,
    postal_code character varying(10) NOT NULL,
    courier_note text,
    subtotal bigint NOT NULL,
    shipping_cost bigint NOT NULL,
    total bigint NOT NULL,
    payment_method character varying(255) NOT NULL,
    payment_status character varying(255) DEFAULT 'paid'::character varying NOT NULL,
    status character varying(255) DEFAULT 'processing'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    user_id bigint,
    snap_token character varying(255),
    payment_proof character varying(255),
    xendit_invoice_id character varying(255),
    xendit_invoice_url character varying(255),
    coupon_id bigint,
    discount_amount bigint DEFAULT '0'::bigint NOT NULL
);


ALTER TABLE public.orders OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 67364)
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.orders_id_seq OWNER TO postgres;

--
-- TOC entry 5293 (class 0 OID 0)
-- Dependencies: 236
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- TOC entry 241 (class 1259 OID 67438)
-- Name: password_reset_otps; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_otps (
    id bigint NOT NULL,
    email character varying(255) NOT NULL,
    otp_code character varying(255) NOT NULL,
    expires_at timestamp(0) without time zone NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_otps OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 67437)
-- Name: password_reset_otps_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.password_reset_otps_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.password_reset_otps_id_seq OWNER TO postgres;

--
-- TOC entry 5294 (class 0 OID 0)
-- Dependencies: 240
-- Name: password_reset_otps_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.password_reset_otps_id_seq OWNED BY public.password_reset_otps.id;


--
-- TOC entry 223 (class 1259 OID 67234)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 67339)
-- Name: products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.products (
    id bigint NOT NULL,
    category_id bigint,
    title_id character varying(255) NOT NULL,
    title_en character varying(255) NOT NULL,
    description_id text NOT NULL,
    description_en text NOT NULL,
    price bigint NOT NULL,
    stock integer DEFAULT 0 NOT NULL,
    images json NOT NULL,
    address character varying(255) NOT NULL,
    is_recommended boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    user_id bigint,
    condition character varying(255) DEFAULT 'baru'::character varying NOT NULL,
    weight integer DEFAULT 1000 NOT NULL,
    sku character varying(255),
    is_flash_sale boolean DEFAULT false NOT NULL,
    flash_sale_price bigint,
    flash_sale_start timestamp(0) without time zone,
    flash_sale_end timestamp(0) without time zone,
    flash_sale_stock integer
);


ALTER TABLE public.products OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 67338)
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.products_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO postgres;

--
-- TOC entry 5295 (class 0 OID 0)
-- Dependencies: 234
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- TOC entry 243 (class 1259 OID 67452)
-- Name: reviews; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reviews (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    product_id bigint NOT NULL,
    order_item_id bigint NOT NULL,
    rating smallint NOT NULL,
    comment text,
    image_path character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.reviews OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 67451)
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reviews_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reviews_id_seq OWNER TO postgres;

--
-- TOC entry 5296 (class 0 OID 0)
-- Dependencies: 242
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- TOC entry 224 (class 1259 OID 67243)
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 67587)
-- Name: settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.settings (
    id bigint NOT NULL,
    key character varying(255) NOT NULL,
    value text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.settings OWNER TO postgres;

--
-- TOC entry 252 (class 1259 OID 67586)
-- Name: settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.settings_id_seq OWNER TO postgres;

--
-- TOC entry 5297 (class 0 OID 0)
-- Dependencies: 252
-- Name: settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.settings_id_seq OWNED BY public.settings.id;


--
-- TOC entry 222 (class 1259 OID 67220)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255),
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    phone character varying(20),
    address text,
    city character varying(100),
    postal_code character varying(10),
    dob date,
    gender character varying(20),
    is_seller boolean DEFAULT false NOT NULL,
    store_name character varying(255),
    google_id character varying(255),
    role character varying(255) DEFAULT 'user'::character varying NOT NULL,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['user'::character varying, 'seller'::character varying, 'superadmin'::character varying])::text[]))),
    CONSTRAINT users_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'blocked'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 67219)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 5298 (class 0 OID 0)
-- Dependencies: 221
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 259 (class 1259 OID 67645)
-- Name: wallet_transactions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wallet_transactions (
    id bigint NOT NULL,
    wallet_id bigint NOT NULL,
    type character varying(255) NOT NULL,
    amount bigint NOT NULL,
    description character varying(255) NOT NULL,
    reference_id character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT wallet_transactions_type_check CHECK (((type)::text = ANY ((ARRAY['credit'::character varying, 'debit'::character varying])::text[])))
);


ALTER TABLE public.wallet_transactions OWNER TO postgres;

--
-- TOC entry 258 (class 1259 OID 67644)
-- Name: wallet_transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.wallet_transactions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.wallet_transactions_id_seq OWNER TO postgres;

--
-- TOC entry 5299 (class 0 OID 0)
-- Dependencies: 258
-- Name: wallet_transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.wallet_transactions_id_seq OWNED BY public.wallet_transactions.id;


--
-- TOC entry 255 (class 1259 OID 67606)
-- Name: wallets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wallets (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    balance bigint DEFAULT '0'::bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.wallets OWNER TO postgres;

--
-- TOC entry 254 (class 1259 OID 67605)
-- Name: wallets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.wallets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.wallets_id_seq OWNER TO postgres;

--
-- TOC entry 5300 (class 0 OID 0)
-- Dependencies: 254
-- Name: wallets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.wallets_id_seq OWNED BY public.wallets.id;


--
-- TOC entry 249 (class 1259 OID 67534)
-- Name: wishlists; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wishlists (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    product_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.wishlists OWNER TO postgres;

--
-- TOC entry 248 (class 1259 OID 67533)
-- Name: wishlists_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.wishlists_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.wishlists_id_seq OWNER TO postgres;

--
-- TOC entry 5301 (class 0 OID 0)
-- Dependencies: 248
-- Name: wishlists_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.wishlists_id_seq OWNED BY public.wishlists.id;


--
-- TOC entry 257 (class 1259 OID 67622)
-- Name: withdrawals; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.withdrawals (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    amount bigint NOT NULL,
    bank_name character varying(255) NOT NULL,
    account_number character varying(255) NOT NULL,
    account_name character varying(255) NOT NULL,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    processed_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT withdrawals_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'approved'::character varying, 'rejected'::character varying])::text[])))
);


ALTER TABLE public.withdrawals OWNER TO postgres;

--
-- TOC entry 256 (class 1259 OID 67621)
-- Name: withdrawals_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.withdrawals_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.withdrawals_id_seq OWNER TO postgres;

--
-- TOC entry 5302 (class 0 OID 0)
-- Dependencies: 256
-- Name: withdrawals_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.withdrawals_id_seq OWNED BY public.withdrawals.id;


--
-- TOC entry 4969 (class 2604 OID 67330)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 4984 (class 2604 OID 67490)
-- Name: conversations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.conversations ALTER COLUMN id SET DEFAULT nextval('public.conversations_id_seq'::regclass);


--
-- TOC entry 4988 (class 2604 OID 67559)
-- Name: coupons id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coupons ALTER COLUMN id SET DEFAULT nextval('public.coupons_id_seq'::regclass);


--
-- TOC entry 4967 (class 2604 OID 67311)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 4966 (class 2604 OID 67281)
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- TOC entry 4985 (class 2604 OID 67512)
-- Name: messages id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.messages ALTER COLUMN id SET DEFAULT nextval('public.messages_id_seq'::regclass);


--
-- TOC entry 4961 (class 2604 OID 67213)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4980 (class 2604 OID 67394)
-- Name: order_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items ALTER COLUMN id SET DEFAULT nextval('public.order_items_id_seq'::regclass);


--
-- TOC entry 4976 (class 2604 OID 67368)
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- TOC entry 4982 (class 2604 OID 67441)
-- Name: password_reset_otps id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_otps ALTER COLUMN id SET DEFAULT nextval('public.password_reset_otps_id_seq'::regclass);


--
-- TOC entry 4970 (class 2604 OID 67342)
-- Name: products id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- TOC entry 4983 (class 2604 OID 67455)
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- TOC entry 4992 (class 2604 OID 67590)
-- Name: settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings ALTER COLUMN id SET DEFAULT nextval('public.settings_id_seq'::regclass);


--
-- TOC entry 4962 (class 2604 OID 67223)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 4997 (class 2604 OID 67648)
-- Name: wallet_transactions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wallet_transactions ALTER COLUMN id SET DEFAULT nextval('public.wallet_transactions_id_seq'::regclass);


--
-- TOC entry 4993 (class 2604 OID 67609)
-- Name: wallets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wallets ALTER COLUMN id SET DEFAULT nextval('public.wallets_id_seq'::regclass);


--
-- TOC entry 4987 (class 2604 OID 67537)
-- Name: wishlists id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlists ALTER COLUMN id SET DEFAULT nextval('public.wishlists_id_seq'::regclass);


--
-- TOC entry 4995 (class 2604 OID 67625)
-- Name: withdrawals id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.withdrawals ALTER COLUMN id SET DEFAULT nextval('public.withdrawals_id_seq'::regclass);


--
-- TOC entry 5244 (class 0 OID 67255)
-- Dependencies: 225
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5245 (class 0 OID 67266)
-- Dependencies: 226
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5252 (class 0 OID 67327)
-- Dependencies: 233
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.categories VALUES (1, 'Gaming Accessories', 'gaming-accessories', '2026-06-28 15:12:46', '2026-06-28 15:12:46');
INSERT INTO public.categories VALUES (2, 'Apparel', 'apparel', '2026-06-28 15:12:46', '2026-06-28 15:12:46');
INSERT INTO public.categories VALUES (3, 'Merchandise', 'merchandise', '2026-06-28 15:12:46', '2026-06-28 15:12:46');
INSERT INTO public.categories VALUES (4, 'Desk Setup', 'desk-setup', '2026-06-28 15:12:46', '2026-06-28 15:12:46');
INSERT INTO public.categories VALUES (5, 'Electronics', 'electronics', '2026-06-28 15:12:46', '2026-06-28 15:12:46');
INSERT INTO public.categories VALUES (6, 'Books & Collectibles', 'books-collectibles', '2026-06-28 15:12:46', '2026-06-28 15:12:46');


--
-- TOC entry 5264 (class 0 OID 67487)
-- Dependencies: 245
-- Data for Name: conversations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.conversations VALUES (1, 106, 5, '2026-06-30 04:15:58', '2026-06-30 04:15:58');


--
-- TOC entry 5270 (class 0 OID 67556)
-- Dependencies: 251
-- Data for Name: coupons; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.coupons VALUES (1, 'DISC20', 'percent', 20, 50000, 20000, 100, 0, '2026-06-29 04:04:43', '2026-07-30 04:04:43', true, '2026-06-30 04:04:43', '2026-06-30 04:04:43');
INSERT INTO public.coupons VALUES (2, 'POT10RB', 'fixed', 10000, 30000, NULL, 100, 0, '2026-06-29 04:04:44', '2026-07-30 04:04:44', true, '2026-06-30 04:04:44', '2026-06-30 04:04:44');


--
-- TOC entry 5250 (class 0 OID 67308)
-- Dependencies: 231
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5248 (class 0 OID 67293)
-- Dependencies: 229
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5247 (class 0 OID 67278)
-- Dependencies: 228
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5266 (class 0 OID 67509)
-- Dependencies: 247
-- Data for Name: messages; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5239 (class 0 OID 67210)
-- Dependencies: 220
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.migrations VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO public.migrations VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO public.migrations VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO public.migrations VALUES (4, '2026_06_19_053957_create_categories_table', 1);
INSERT INTO public.migrations VALUES (5, '2026_06_19_053958_create_products_table', 1);
INSERT INTO public.migrations VALUES (6, '2026_06_19_144300_create_orders_table', 1);
INSERT INTO public.migrations VALUES (7, '2026_06_19_144301_create_order_items_table', 1);
INSERT INTO public.migrations VALUES (8, '2026_06_23_042837_add_profile_columns_to_users_table', 1);
INSERT INTO public.migrations VALUES (9, '2026_06_23_042841_add_user_id_to_orders_table', 1);
INSERT INTO public.migrations VALUES (10, '2026_06_23_152317_add_dob_and_gender_to_users_table', 1);
INSERT INTO public.migrations VALUES (11, '2026_06_25_000956_add_seller_columns_to_users_table', 1);
INSERT INTO public.migrations VALUES (12, '2026_06_25_000957_add_user_id_to_products_table', 1);
INSERT INTO public.migrations VALUES (13, '2026_06_25_001602_add_snap_token_to_orders_table', 1);
INSERT INTO public.migrations VALUES (14, '2026_06_28_152719_add_details_to_products_table', 2);
INSERT INTO public.migrations VALUES (15, '2026_06_28_153850_add_google_id_to_users_table', 3);
INSERT INTO public.migrations VALUES (16, '2026_06_28_153852_create_password_reset_otps_table', 3);
INSERT INTO public.migrations VALUES (17, '2026_06_29_032504_create_reviews_table', 4);
INSERT INTO public.migrations VALUES (18, '2026_06_29_033522_add_tracking_columns_to_order_items_table', 5);
INSERT INTO public.migrations VALUES (19, '2026_06_29_034530_create_conversations_table', 6);
INSERT INTO public.migrations VALUES (20, '2026_06_29_034531_create_messages_table', 6);
INSERT INTO public.migrations VALUES (21, '2026_06_29_080906_add_payment_proof_to_orders_table', 7);
INSERT INTO public.migrations VALUES (22, '2026_06_30_035434_add_xendit_to_orders_table', 8);
INSERT INTO public.migrations VALUES (23, '2026_06_30_035755_create_wishlists_table', 9);
INSERT INTO public.migrations VALUES (24, '2026_06_30_040010_create_coupons_table', 10);
INSERT INTO public.migrations VALUES (25, '2026_06_30_040039_add_coupon_to_orders_table', 10);
INSERT INTO public.migrations VALUES (26, '2026_06_30_040210_add_flash_sale_to_products_table', 11);
INSERT INTO public.migrations VALUES (27, '2026_06_30_153952_create_settings_table', 12);
INSERT INTO public.migrations VALUES (28, '2026_06_30_153953_add_role_and_status_to_users_table', 12);
INSERT INTO public.migrations VALUES (29, '2026_06_30_153955_create_wallets_table', 12);
INSERT INTO public.migrations VALUES (30, '2026_06_30_153957_create_withdrawals_table', 12);
INSERT INTO public.migrations VALUES (31, '2026_06_30_153959_create_wallet_transactions_table', 12);


--
-- TOC entry 5258 (class 0 OID 67391)
-- Dependencies: 239
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.order_items VALUES (1, 1, 3, 'Tas Ransel Harian', 350000, 1, 350000, '2026-06-29 03:32:46', '2026-06-29 04:10:03', NULL, NULL, 'completed');
INSERT INTO public.order_items VALUES (2, 2, 99, 'Blus Wanita Lengan Lonceng', 250000, 1, 250000, '2026-06-29 04:12:15', '2026-06-29 04:12:15', NULL, 'jne', 'processing');
INSERT INTO public.order_items VALUES (3, 3, 9, 'Mouse Nirkabel Ergonomis', 250000, 1, 250000, '2026-06-30 04:16:28', '2026-06-30 04:16:28', NULL, 'jne', 'processing');
INSERT INTO public.order_items VALUES (4, 4, 10, 'Novel Grafis Fantasi', 120000, 1, 120000, '2026-06-30 05:04:50', '2026-06-30 05:04:50', NULL, 'jne', 'processing');
INSERT INTO public.order_items VALUES (5, 5, 7, 'Mesin Kopi Otomatis', 750000, 1, 750000, '2026-06-30 05:06:21', '2026-06-30 05:06:21', NULL, 'jne', 'processing');
INSERT INTO public.order_items VALUES (6, 6, 105, 'Kipas Angin Meja', 250000, 1, 250000, '2026-06-30 05:24:54', '2026-06-30 05:24:54', NULL, 'jne', 'processing');
INSERT INTO public.order_items VALUES (7, 6, 97, 'Celana Training Jogger', 350000, 1, 350000, '2026-06-30 05:24:54', '2026-06-30 05:24:54', NULL, 'jne', 'processing');
INSERT INTO public.order_items VALUES (8, 7, 106, 'Kabel', 1000, 1, 1000, '2026-06-30 05:25:26', '2026-06-30 05:25:26', NULL, 'jne', 'processing');
INSERT INTO public.order_items VALUES (9, 8, 10, 'Novel Grafis Fantasi', 120000, 1, 120000, '2026-06-30 05:25:50', '2026-06-30 05:25:50', NULL, 'jne', 'processing');


--
-- TOC entry 5256 (class 0 OID 67365)
-- Dependencies: 237
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.orders VALUES (1, 'MCT-20260629-JPS7PA', 'Pangeran Valerensco Rivaldi Hutabarat', '082275065026', 'Jl. Dakota, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175', 'Kota Bandung', '40175', NULL, 350000, 25000, 375000, 'bca_va', 'pending', 'completed', '2026-06-29 03:32:46', '2026-06-29 04:10:03', 106, 'dummy_snap_token_ddT3h3g8LS', NULL, NULL, NULL, NULL, 0);
INSERT INTO public.orders VALUES (2, 'MCT-20260629-82WQHE', 'Pangeran Valerensco Rivaldi Hutabarat', '082275065026', 'Jl. Dakota, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175', 'Kota Bandung', '40175', NULL, 250000, 15000, 265000, 'bca_va', 'pending', 'processing', '2026-06-29 04:12:15', '2026-06-29 04:12:15', 106, 'dummy_snap_token_DGPw8rncI9', NULL, NULL, NULL, NULL, 0);
INSERT INTO public.orders VALUES (3, 'MCT-20260630-Q4MV6Z', 'Pangeran Valerensco Rivaldi Hutabarat', '082275065026', 'Jl. Dakota, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175', 'Kota Bandung', '40175', NULL, 250000, 15000, 265000, 'xendit', 'pending', 'processing', '2026-06-30 04:16:28', '2026-06-30 04:16:28', 106, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO public.orders VALUES (4, 'MCT-20260630-T125S9', 'Pangeran Valerensco Rivaldi Hutabarat', '082275065026', 'Jl. Dakota, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175', 'Kota Bandung', '40175', NULL, 120000, 15000, 135000, 'xendit', 'pending', 'processing', '2026-06-30 05:04:50', '2026-06-30 05:04:51', 106, NULL, NULL, '6a434e6bf07617c3fc718684', 'https://checkout-staging.xendit.co/web/6a434e6bf07617c3fc718684', NULL, 0);
INSERT INTO public.orders VALUES (5, 'MCT-20260630-5HZQAE', 'Pangeran Valerensco Rivaldi Hutabarat', '082275065026', 'Jl. Dakota, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175', 'Kota Bandung', '40175', NULL, 750000, 15000, 765000, 'xendit', 'pending', 'processing', '2026-06-30 05:06:21', '2026-06-30 05:06:23', 106, NULL, NULL, '6a434ec7f07617c3fc71874c', 'https://checkout-staging.xendit.co/web/6a434ec7f07617c3fc71874c', NULL, 0);
INSERT INTO public.orders VALUES (6, 'MCT-20260630-BKWC5S', 'Pangeran Valerensco Rivaldi Hutabarat', '082275065026', 'Jl. Dakota, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175', 'Kota Bandung', '40175', NULL, 600000, 30000, 630000, 'xendit', 'pending', 'processing', '2026-06-30 05:24:54', '2026-06-30 05:24:55', 106, NULL, NULL, '6a43531ff07617c3fc7190b9', 'https://checkout-staging.xendit.co/web/6a43531ff07617c3fc7190b9', NULL, 0);
INSERT INTO public.orders VALUES (7, 'MCT-20260630-DWN5TS', 'Pangeran Valerensco Rivaldi Hutabarat', '082275065026', 'Jl. Dakota, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175', 'Kota Bandung', '40175', NULL, 1000, 15000, 16000, 'cod', 'pending', 'processing', '2026-06-30 05:25:26', '2026-06-30 05:25:26', 106, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO public.orders VALUES (8, 'MCT-20260630-AXGS6D', 'Pangeran Valerensco Rivaldi Hutabarat', '082275065026', 'Jl. Dakota, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175', 'Kota Bandung', '40175', NULL, 120000, 15000, 135000, 'xendit', 'pending', 'processing', '2026-06-30 05:25:50', '2026-06-30 05:25:51', 106, NULL, NULL, '6a435357f07617c3fc719126', 'https://checkout-staging.xendit.co/web/6a435357f07617c3fc719126', NULL, 0);


--
-- TOC entry 5260 (class 0 OID 67438)
-- Dependencies: 241
-- Data for Name: password_reset_otps; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.password_reset_otps VALUES (1, 'pangeranvalerensco@gmail.com', '731797', '2026-06-29 08:11:54', '2026-06-29 07:56:54', '2026-06-29 07:56:54');


--
-- TOC entry 5242 (class 0 OID 67234)
-- Dependencies: 223
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5254 (class 0 OID 67339)
-- Dependencies: 235
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.products VALUES (6, 6, 'Matras Yoga Anti-Selip', 'Anti-Slip Yoga Mat', 'Matras yoga tebal 6mm yang empuk dan tidak licin, memberikan stabilitas dan kenyamanan saat berlatih.', 'A thick 6mm yoga mat that is soft and non-slip, providing stability and comfort during practice.', 275000, 60, '["https:\/\/tse4.mm.bing.net\/th\/id\/OIP.uVyOP5KRvvGRrb_tqSrr_wHaHa?pid=Api&P=0&h=180","https:\/\/tse2.mm.bing.net\/th\/id\/OIP.S9xqFgIw3HCDyLOPq7DoSwHaHa?pid=Api&P=0&h=180","https:\/\/images.tokopedia.net\/img\/JFrBQq\/2023\/11\/22\/f60cb2ec-c806-48ac-be9c-43918b0dbf8b.jpg"]', 'Pusat Grosir Olahraga, Jl. Cihampelas No. 98, Bandung, Jawa Barat', false, '2026-06-28 15:12:49', '2026-06-28 15:12:49', 6, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (8, 1, 'Celana Chino Slim-Fit', 'Slim-Fit Chino Pants', 'Celana chino dengan potongan slim-fit modern yang terbuat dari bahan katun twill yang nyaman.', 'Modern slim-fit chino pants made from comfortable cotton twill material.', 320000, 75, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98x-lmohse1d7h6cab","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul5-liobp8b1opee6b","https:\/\/dynamic.zacdn.com\/2IHC-uZHzqxBcVpZ1V0K8J6KnXQ=\/filters:quality(70):format(webp)\/https:\/\/static-id.zacdn.com\/p\/house-of-cuff-1770-9981872-1.jpg"]', 'Factory Outlet, Jl. R.E. Martadinata No. 55, Bandung, Jawa Barat', false, '2026-06-28 15:12:49', '2026-06-28 15:12:49', 8, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (11, 4, 'Jam Tangan Kulit Klasik', 'Classic Leather Watch', 'Jam tangan analog dengan tali kulit asli dan bingkai stainless steel. Desain elegan yang cocok untuk segala acara.', 'An analog watch with a genuine leather strap and stainless steel frame. An elegant design suitable for all occasions.', 650000, 40, '["https:\/\/tse4.mm.bing.net\/th\/id\/OIP.gIu4VGWwweMljSy0IyX6QwHaHa?pid=Api&P=0&h=180","https:\/\/cdn1.productnation.co\/stg\/sites\/5\/5d0c4dd7d4d99.jpeg","https:\/\/tse2.mm.bing.net\/th\/id\/OIP.u4QWj_yyxCcmQjbXeXqE4wHaJ4?pid=Api&P=0&h=180"]', 'Plaza Senayan, Lantai 1, Jl. Asia Afrika, Jakarta Pusat, DKI Jakarta', false, '2026-06-28 15:12:50', '2026-06-28 15:12:50', 11, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (12, 5, 'Tabir Surya SPF 50+', 'Sunscreen SPF 50+', 'Lindungi kulit Anda dari sinar UV dengan tabir surya ringan yang tidak lengket dan cepat meresap.', 'Protect your skin from UV rays with this lightweight, non-sticky, and fast-absorbing sunscreen.', 175000, 85, '["https:\/\/tse3.mm.bing.net\/th\/id\/OIP.6xoN1q743VWQMyA_Y9FnvQHaHa?pid=Api&P=0&h=180","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul7-lftlrdsnfieze9","https:\/\/tse2.mm.bing.net\/th\/id\/OIP.6OXTLEU7WGdRziu3Cd10aQHaHa?pid=Api&P=0&h=180"]', 'Watsons, Tunjungan Plaza 3, Surabaya, Jawa Timur', true, '2026-06-28 15:12:51', '2026-06-28 15:12:51', 12, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (2, 2, 'Keyboard Mekanikal Gaming', 'Gaming Mechanical Keyboard', 'Keyboard mekanikal dengan switch biru dan lampu latar RGB yang bisa dikustomisasi. Rasakan pengalaman mengetik yang responsif.', 'Mechanical keyboard with blue switches and customizable RGB backlighting. Experience a responsive typing feel.', 899000, 20, '["https:\/\/tse2.mm.bing.net\/th\/id\/OIP.r-iPN_csGAyVSCt6O8q2iQHaEY?pid=Api&P=0&h=180","https:\/\/m.media-amazon.com\/images\/I\/71jPClBDPDL._AC_SL1500_.jpg"]', 'Harco Mangga Dua, Lantai 3, Blok B No. 5, Jakarta Pusat, DKI Jakarta', false, '2026-06-28 15:12:47', '2026-06-30 04:04:37', 2, 'baru', 1000, NULL, true, 15000, '2026-06-29 04:04:37', '2026-07-02 04:04:37', 50);
INSERT INTO public.products VALUES (9, 2, 'Mouse Nirkabel Ergonomis', 'Ergonomic Wireless Mouse', 'Mouse nirkabel dengan desain ergonomis untuk kenyamanan tangan. Dilengkapi dengan koneksi 2.4GHz yang stabil.', 'An ergonomic wireless mouse designed for hand comfort. Equipped with a stable 2.4GHz connection.', 250000, 109, '["https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-7rd4p-lvzkfrkfk41v2f","https:\/\/techphoria.id\/wp-content\/uploads\/2024\/11\/5-Jenis-Mouse-Nirkabel-Ergonomis-yang-Paling-Dicari.webp.jpg","https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-7rbne-lo9k815bxh01da"]', 'Mal Ambassador, Lantai 2, Jl. Prof. DR. Satrio, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:12:50', '2026-06-30 04:16:28', 9, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (7, 5, 'Mesin Kopi Otomatis', 'Automatic Coffee Machine', 'Mulai hari Anda dengan kopi segar. Mesin kopi ini bisa membuat espresso dan lungo dengan satu sentuhan.', 'Start your day with fresh coffee. This coffee machine can make espresso and lungo with a single touch.', 750000, 24, '["https:\/\/id.delonghi.com\/wp-content\/uploads\/2022\/11\/218828.jpg","https:\/\/s-ecom.ottenstatic.com\/original\/6290891f047e7971139575.jpg","https:\/\/astromesin.com\/wp-content\/uploads\/2017\/12\/Mesin-Kopi-Full-Otomatis-Astro.jpg"]', 'Toko Peralatan Kopi, Jl. Senopati No. 64, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:12:49', '2026-06-30 05:06:21', 7, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (10, 3, 'Novel Grafis Fantasi', 'Fantasy Graphic Novel', 'Ikuti petualangan epik di dunia sihir melalui ilustrasi yang memukau dalam novel grafis ini.', 'Follow an epic adventure in a world of magic through stunning illustrations in this graphic novel.', 120000, 88, '["https:\/\/tse3.mm.bing.net\/th\/id\/OIP.drtApKsKtbRNcpL1COkAkQHaHa?pid=Api&P=0&h=180","https:\/\/cdn.idntimes.com\/content-images\/community\/2024\/01\/monica-3dcover-2000x-1-8656588e425b787fe5f397b37ec60c04-a239ed7732a64a97492e7d608cc62630.jpg","https:\/\/awsimages.detik.net.id\/community\/media\/visual\/2024\/01\/26\/novel-grafis-the-hobbit.jpeg?w=700&q=90"]', 'Toko Buku Togamas, Jl. Affandi No. 5, Yogyakarta, DIY', true, '2026-06-28 15:12:50', '2026-06-30 05:25:50', 10, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (13, 6, 'Botol Minum Olahraga 1L', '1L Sports Water Bottle', 'Botol minum bebas BPA dengan penanda waktu untuk memastikan hidrasi Anda tercukupi sepanjang hari.', 'BPA-free water bottle with time markers to ensure you stay hydrated throughout the day.', 150000, 120, '["https:\/\/tse2.mm.bing.net\/th\/id\/OIP.Qw54SS_Nwcobm4uKOW2kWAHaHa?pid=Api&P=0&h=180","https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/catalog-image\/106\/MTA-177424495\/no-brand_no-brand_full02.jpg","https:\/\/down-id.img.susercontent.com\/file\/24033d6cc11e7234ab00f47885737313"]', 'Toko Olahraga Jaya, Jl. Gajah Mada No. 12, Semarang, Jawa Tengah', false, '2026-06-28 15:12:51', '2026-06-28 15:12:51', 13, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (14, 6, 'Blender Jus Portabel', 'Portable Juice Blender', 'Buat jus segar di mana saja dengan blender portabel yang bisa diisi ulang menggunakan USB.', 'Make fresh juice anywhere with this portable blender that can be recharged via USB.', 450000, 30, '["https:\/\/tse2.mm.bing.net\/th\/id\/OIP.3056AobM3hTbyuHpPHubVwHaHB?pid=Api&P=0&h=180","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul9-ljo8yogalq8rd1","https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-23020-954q6t16wknv38"]', 'ACE Hardware, Jl. Sunset Road, Kuta, Bali', true, '2026-06-28 15:12:52', '2026-06-28 15:12:52', 14, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (15, 1, 'Hoodie Polos Fleece', 'Plain Fleece Hoodie', 'Hoodie basic yang terbuat dari bahan fleece tebal yang lembut, memberikan kehangatan maksimal.', 'A basic hoodie made from soft, thick fleece material, providing maximum warmth.', 380000, 65, '["https:\/\/tse1.mm.bing.net\/th\/id\/OIP.LNQJOgrGI4Wa2vwYS7stlgHaJ4?pid=Api&P=0&h=180","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r991-lw45s44w5pqlb0","https:\/\/dynamic.zacdn.com\/5N1-uLFj08RBsITy45QiURHxbB4=\/filters:quality(70):format(webp)\/https:\/\/static-id.zacdn.com\/p\/hamlin-9999-0396824-2.jpg"]', 'Jl. Trunojoyo No. 4, Bandung, Jawa Barat', true, '2026-06-28 15:12:52', '2026-06-28 15:12:52', 15, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (16, 2, 'Speaker Bluetooth Portabel', 'Portable Bluetooth Speaker', 'Speaker ringkas dengan kualitas suara bass yang kuat dan baterai yang tahan lama. Tahan percikan air.', 'A compact speaker with strong bass sound quality and a long-lasting battery. Splash-proof.', 550000, 55, '["https:\/\/tse4.mm.bing.net\/th\/id\/OIP.8C3wppDnuL1etqX0qH3vCgHaHa?pid=Api&P=0&h=180","https:\/\/tse2.mm.bing.net\/th\/id\/OIP.rNxkdzB6EsyKwx3tG_OZvAHaHa?pid=Api&P=0&h=180","https:\/\/i5.walmartimages.com\/asr\/52ff3b2a-29e1-4772-8bb2-0afe221f299c_1.c8cb9cea86ad3c723c2ed5110ed5120f.jpeg"]', 'Toko Elektronik Sinar Jaya, Jl. Ahmad Yani No. 150, Medan, Sumatera Utara', false, '2026-06-28 15:12:53', '2026-06-28 15:12:53', 16, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (17, 3, 'Buku Biografi Inspiratif', 'Inspiring Biography Book', 'Kisah hidup seorang inovator yang mengubah dunia. Pelajari perjalanan dan pemikirannya.', 'The life story of an innovator who changed the world. Learn about their journey and mindset.', 180000, 70, '["https:\/\/ecs7.tokopedia.net\/img\/cache\/500-square\/VqbcmM\/2020\/9\/24\/2b03eb80-1d4f-4986-b52e-144403930028.jpg","https:\/\/down-tw.img.susercontent.com\/file\/tw-11134201-7r98o-lklzo9ujtw3j2a","https:\/\/down-id.img.susercontent.com\/file\/b272554e57e968940bf99ab564d29fe3"]', 'Periplus, Pondok Indah Mall 2, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:12:53', '2026-06-28 15:12:53', 17, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (18, 4, 'Kacamata Hitam Aviator', 'Aviator Sunglasses', 'Kacamata hitam model aviator dengan lensa polarisasi untuk melindungi mata dari silau dan sinar UV.', 'Aviator-style sunglasses with polarized lenses to protect eyes from glare and UV rays.', 280000, 88, '["https:\/\/tse4.mm.bing.net\/th\/id\/OIP.qGk7Mnc4N6-pyHBqG9QNrgHaHa?pid=Api&P=0&h=180","https:\/\/tse3.mm.bing.net\/th\/id\/OIP._XUSMd2qBXw-6EYdwpBfcAHaHa?pid=Api&P=0&h=180","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98x-luvrotkuyfgce6"]', 'Optik Melawai, Grand Indonesia, Jakarta Pusat, DKI Jakarta', true, '2026-06-28 15:12:54', '2026-06-28 15:12:54', 18, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (19, 5, 'Pelembap Wajah Harian', 'Daily Face Moisturizer', 'Pelembap ringan dengan asam hialuronat untuk menjaga kelembapan kulit sepanjang hari tanpa rasa berminyak.', 'A lightweight moisturizer with hyaluronic acid to maintain skin hydration all day without a greasy feel.', 210000, 150, '["https:\/\/p16-va.lemon8cdn.com\/tos-alisg-v-a3e477-sg\/5f802b66482f43039be653ccad543cb1~tplv-tej9nj120t-origin.webp","https:\/\/tse4.mm.bing.net\/th\/id\/OIP.g72ZGh_smZawUi14Q17sqwHaGD?pid=Api&P=0&h=180","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98o-lz4mlu6vq1pcce"]', 'Sephora, Kota Kasablanka, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:12:54', '2026-06-28 15:12:54', 19, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (20, 6, 'Sepatu Lari Responsif', 'Responsive Running Shoes', 'Sepatu lari dengan bantalan busa responsif yang memberikan energi kembali di setiap langkah.', 'Running shoes with responsive foam cushioning that provides energy return with every step.', 950000, 45, '["https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/catalog-image\/MTA-176341990\/nike_nike_women_running_pegasus_41_road_shoes_sepatu_lari_wanita_-fd2723-002-_full08_o236l0cl.jpeg","https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/catalog-image\/MTA-176341990\/nike_nike_women_running_pegasus_41_road_shoes_sepatu_lari_wanita_-fd2723-002-_full02_lut0q3w5.jpeg","https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/catalog-image\/MTA-176341990\/nike_nike_women_running_pegasus_41_road_shoes_sepatu_lari_wanita_-fd2723-002-_full09_k4rlbnb0.jpeg"]', 'Planet Sports, Senayan City, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:12:54', '2026-06-28 15:12:54', 20, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (21, 1, 'Panci Anti-Lengket Set', 'Non-Stick Pan Set', 'Set panci dan wajan dengan lapisan anti-lengket keramik yang aman untuk kesehatan dan mudah dibersihkan.', 'A set of pots and pans with a healthy and easy-to-clean ceramic non-stick coating.', 350000, 60, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98y-llu8sqrbmpvy0b","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r992-llu8sqrbo4geb3","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98y-lphgapipj8hh24"]', 'Informa, Living World Alam Sutera, Tangerang Selatan, Banten', false, '2026-06-28 15:12:55', '2026-06-28 15:12:55', 21, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (22, 1, 'Kemeja Formal Katun', 'Cotton Formal Shirt', 'Kemeja lengan panjang bahan katun premium yang tidak mudah kusut, cocok untuk acara formal atau kerja.', 'A premium cotton long-sleeve shirt that is wrinkle-resistant, perfect for formal events or work.', 420000, 70, '["https:\/\/down-id.img.susercontent.com\/file\/165f63895b0b42694496a11da9c3d27a","https:\/\/down-my.img.susercontent.com\/file\/c12ff2736129e7e1f6c3d66745c9937f","https:\/\/down-my.img.susercontent.com\/file\/id-11134207-7qul8-lgpeqctgbepva2"]', 'Pusat Grosir Tanah Abang, Blok A, Lantai 5, Jakarta Pusat, DKI Jakarta', true, '2026-06-28 15:12:55', '2026-06-28 15:12:55', 22, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (23, 2, 'Power Bank 10000mAh', '10000mAh Power Bank', 'Power bank ringkas dengan kapasitas 10000mAh dan fitur pengisian cepat. Memiliki dua port USB.', 'A compact power bank with a 10000mAh capacity and fast charging feature. Has two USB ports.', 300000, 100, '["https:\/\/www.cellularline.com\/medias\/PBESSENCE10000K-01-MAIN-HR.jpg?context=bWFzdGVyfHJvb3R8NjE1MDcxfGltYWdlL2pwZWd8aDAzL2hjZS85NDY0OTU4MDU4NTI2LmpwZ3w0Yzc5OTRjNjZiYmY4Mjg0NzZlMTEyOGE5NDk0OTgzYjhjZDE5NTI5YjNmNjVmMzVlZDhhMmNiNmM2NTRmODNk","https:\/\/www.niclick.it\/wp-content\/uploads\/2023\/09\/Cellularline_PBESSENCEPD10000G_01_side_power_bank_10000_mAh_20_watt_petrol_blau_1920x1920.jpeg","https:\/\/media.adeo.com\/marketplace\/MKP\/88585603\/16143d8c8419f940558e97b92e207f3f.jpeg"]', 'Roxy Mas Square, Jl. KH Hasyim Ashari, Jakarta Pusat, DKI Jakarta', true, '2026-06-28 15:12:55', '2026-06-28 15:12:55', 23, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (24, 3, 'Kamus Visual Tiga Bahasa', 'Trilingual Visual Dictionary', 'Kamus visual untuk anak-anak dan pemula dalam tiga bahasa: Indonesia, Inggris, dan Mandarin.', 'A visual dictionary for children and beginners in three languages: Indonesian, English, and Mandarin.', 250000, 65, '["https:\/\/down-id.img.susercontent.com\/file\/3265cac2e1d424e64dbd0876bd7e9527","https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-7qveq-ljw1vi86bkpj74","https:\/\/down-id.img.susercontent.com\/file\/243d86b0b0558d4bbbee5227d2707b9c"]', 'Penerbit Erlangga, Jl. Baping Raya No. 100, Jakarta Timur, DKI Jakarta', false, '2026-06-28 15:12:56', '2026-06-28 15:12:56', 24, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (25, 4, 'Dompet Kulit Asli', 'Genuine Leather Wallet', 'Dompet pria dari kulit sapi asli dengan banyak slot kartu dan desain klasik yang elegan.', 'A men''s wallet made from genuine cowhide leather with multiple card slots and a classic, elegant design.', 290000, 95, '["https:\/\/cf.shopee.co.id\/file\/8a6446d802702f8a68c4869386b80e34","https:\/\/filebroker-cdn.lazada.co.id\/kf\/S3f3767ee08e74577926b3a7beace9a0bl.jpg","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul4-lg2fdiianlwof0"]', 'Pengrajin Kulit Manding, Jl. DR. Wahidin Sudiro Husodo, Bantul, DIY', true, '2026-06-28 15:12:56', '2026-06-28 15:12:56', 25, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (26, 5, 'Lipstik Matte Tahan Lama', 'Long-Lasting Matte Lipstick', 'Lipstik matte dengan formula yang ringan di bibir dan tahan hingga 12 jam tanpa membuat bibir kering.', 'A matte lipstick with a lightweight formula that lasts up to 12 hours without drying out the lips.', 135000, 130, '["https:\/\/cf.shopee.com.my\/file\/c1348c1ec6be84579ae64af9bf23e4a3","https:\/\/down-id.img.susercontent.com\/file\/cc37594b14ca91ee5498ce2d20610485","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul6-lj62awmnjld9db"]', 'Sociolla, Mall Kelapa Gading, Jakarta Utara, DKI Jakarta', false, '2026-06-28 15:12:57', '2026-06-28 15:12:57', 26, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (27, 6, 'Tali Skipping Cepat', 'Speed Jump Rope', 'Tali skipping dengan pegangan ringan dan kabel baja yang bisa diatur panjangnya, cocok untuk latihan kardio.', 'A jump rope with lightweight handles and an adjustable steel cable, perfect for cardio workouts.', 95000, 150, '["https:\/\/tse2.mm.bing.net\/th\/id\/OIP.Tq7oj0p0jPhwHXd_YDP91AHaHa?pid=Api&P=0&h=180","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98t-lt4qdrcv6uvtbe","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r991-lr2t3lq4cbbd83"]', 'Decathlon, Mall Taman Anggrek, Jakarta Barat, DKI Jakarta', true, '2026-06-28 15:12:57', '2026-06-28 15:12:57', 27, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (28, 6, 'Air Fryer Digital 4L', '4L Digital Air Fryer', 'Menggoreng lebih sehat dengan sedikit atau tanpa minyak. Kapasitas 4 liter dengan panel sentuh digital.', 'A healthier way to fry with little to no oil. 4-liter capacity with a digital touch panel.', 950000, 33, '["https:\/\/down-br.img.susercontent.com\/file\/8a5a7da8d1a433d757a9ef5340b5112a","https:\/\/http2.mlstatic.com\/D_NQ_NP_2X_876754-MLB51636134245_092022-F.jpg","https:\/\/a-static.mlcdn.com.br\/1500x1500\/fritadeira-mondial-air-fryer-family-inox-digital-touch-1500w-4l-af26\/angeloni2\/4172504\/ec3e7a6e41da5f49a44fdbeb98b0a5da.jpg"]', 'Hartono Elektronika, Jl. Dr. Ir. H. Soekarno, Surabaya, Jawa Timur', true, '2026-06-28 15:12:58', '2026-06-28 15:12:58', 28, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (29, 1, 'Gaun Musim Panas Bunga', 'Floral Summer Dress', 'Gaun midi ringan dengan motif bunga yang ceria, cocok untuk jalan-jalan di pantai atau acara santai.', 'A lightweight midi dress with a cheerful floral pattern, perfect for beach walks or casual events.', 375000, 58, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98s-loeu4vwr99aye9","https:\/\/down-id.img.susercontent.com\/file\/sg-11134202-7rd5v-lu4krolvxg4j13","https:\/\/down-id.img.susercontent.com\/file\/id-11134201-7r98x-ltdyg20kwqll7e"]', 'Boutique The Label, Jl. Kayu Aya, Seminyak, Bali', true, '2026-06-28 15:12:58', '2026-06-28 15:12:58', 29, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (30, 2, 'Webcam HD 1080p', '1080p HD Webcam', 'Webcam dengan resolusi Full HD 1080p dan mikrofon internal, ideal untuk rapat online atau streaming.', 'A webcam with Full HD 1080p resolution and a built-in microphone, ideal for online meetings or streaming.', 480000, 77, '["https:\/\/media.s-bol.com\/x66V9358OJRJ\/550x611.jpg","https:\/\/media.s-bol.com\/Y77QY7RJZVKK\/1200x827.jpg","https:\/\/m.media-amazon.com\/images\/I\/71c6VcE1DbL._AC_SL1500_.jpg"]', 'Bandung Electronic Center (BEC), Lantai 1, Bandung, Jawa Barat', false, '2026-06-28 15:12:59', '2026-06-28 15:12:59', 30, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (31, 3, 'Cerpen Misteri', 'Mystery Short Stories', 'Selami cerita pendek misteri yang akan membuat Anda terus menebak hingga halaman terakhir.', 'Dive into mystery short stories that will keep you guessing until the very last page.', 98000, 115, '["https:\/\/down-id.img.susercontent.com\/file\/0e8b158605c0d4778874b545c08dcddd","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r992-lnkxa3mt70ba53","https:\/\/blogger.googleusercontent.com\/img\/b\/R29vZ2xl\/AVvXsEjbdOYRlGYp5GcilQSKHPBgKMCUs6mAtzRDAFNJ2Q81gH7NJ6DOB625Up_lMnahfXEYu-IN96BbaoU5rLQrEsvl8EjMBdCUn6cUqTeMks5jsFRPdIlendwxTGf8DYk9XU6JzQH7\/s1600\/Buku+Kumpulan+Cerpen+Buddhis%253B+Misteri+Penunggu+Pohon+Tua.jpg"]', 'Gudang Buku, Jl. Palasari No. 8, Bandung, Jawa Barat', true, '2026-06-28 15:12:59', '2026-06-28 15:12:59', 31, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (32, 4, 'Topi Baseball Polos', 'Plain Baseball Cap', 'Topi baseball katun dengan desain minimalis dan tali pengatur ukuran di bagian belakang.', 'A cotton baseball cap with a minimalist design and an adjustable strap at the back.', 140000, 200, '["https:\/\/cf.shopee.co.id\/file\/01dffcad86553bae7502761979b019f7","https:\/\/cf.shopee.co.id\/file\/a842dc7703ac5b241ad984059977865c","https:\/\/down-id.img.susercontent.com\/file\/3f571188aee7122145e64b30b2b66e97"]', 'ITC Mangga Dua, Lantai 4, Blok D, Jakarta Utara, DKI Jakarta', false, '2026-06-28 15:12:59', '2026-06-28 15:12:59', 32, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (33, 5, 'Masker Wajah Tanah Liat', 'Clay Face Mask', 'Masker dari tanah liat untuk membersihkan pori-pori secara mendalam dan mengurangi minyak berlebih pada wajah.', 'A clay mask to deeply cleanse pores and reduce excess oil on the face.', 125000, 95, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98o-lkxjvxli1zovb4","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r992-ll7mvhwtbve387","https:\/\/media.istockphoto.com\/id\/1488125022\/id\/foto\/masker-wajah-tanah-liat-hijau-dalam-mangkuk-putih-dan-spatula-masker.jpg?s=612x612&w=is&k=20&c=2uMJDui9QeaI7CNUuOn0Ep5r8uMdbOP6TjCXFZi82IE="]', 'Guardian, Paris Van Java Mall, Bandung, Jawa Barat', true, '2026-06-28 15:13:00', '2026-06-28 15:13:00', 33, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (34, 6, 'Sarung Tangan Fitness', 'Fitness Gloves', 'Sarung tangan dengan bantalan empuk untuk melindungi telapak tangan saat mengangkat beban dan mencegah kapalan.', 'Gloves with soft padding to protect the palms during weightlifting and prevent calluses.', 180000, 80, '["https:\/\/down-id.img.susercontent.com\/file\/bb3a9e51042a5af0d45c0bf252d52957","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul4-linuda7hz25fe0","https:\/\/down-id.img.susercontent.com\/file\/f6a14a2c38d3e35b05155a7136ffc1d7"]', 'Pusat Kebugaran, Jl. Pemuda No. 72, Rawamangun, Jakarta Timur, DKI Jakarta', false, '2026-06-28 15:13:00', '2026-06-28 15:13:00', 34, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (35, 2, 'Set Alat Makan Stainless', 'Stainless Steel Cutlery Set', 'Set alat makan 16 buah yang terbuat dari stainless steel berkualitas tinggi. Desain modern dan elegan.', 'A 16-piece cutlery set made from high-quality stainless steel. Modern and elegant design.', 280000, 55, '["https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-23020-s3b94l3dh4mv88","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7rase-m0l7pwddeetaf7","https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/111\/MTA-75386955\/oem_oem_full01.jpg"]', 'IKEA Kota Baru Parahyangan, Padalarang, Jawa Barat', false, '2026-06-28 15:13:00', '2026-06-28 15:13:00', 35, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (36, 1, 'Celana Kargo Taktikal', 'Tactical Cargo Pants', 'Celana kargo dengan banyak saku yang terbuat dari bahan ripstop yang kuat, cocok untuk kegiatan outdoor.', 'Multi-pocket cargo pants made from durable ripstop material, suitable for outdoor activities.', 410000, 60, '["https:\/\/lzd-img-global.slatic.net\/g\/p\/5a358c77230711b7bde5db29f91cd4ca.png_720x720q80.png","https:\/\/down-id.img.susercontent.com\/file\/34c1f968c3bfeec9bba0cc33896a429f","https:\/\/down-id.img.susercontent.com\/file\/dfaabb52eff2c780dcb96b107e5a7920"]', 'Toko Perlengkapan Outdoor, Jl. Veteran No. 33, Malang, Jawa Timur', false, '2026-06-28 15:13:01', '2026-06-28 15:13:01', 36, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (37, 2, 'Tablet Menggambar Digital', 'Digital Drawing Tablet', 'Tablet menggambar dengan area aktif yang luas dan pena sensitif tekanan untuk para seniman digital.', 'A drawing tablet with a large active area and a pressure-sensitive pen for digital artists.', 1100000, 42, '["https:\/\/images.tokopedia.net\/img\/cache\/700\/hDjmkQ\/2024\/3\/16\/a1a35016-2994-4689-b64c-9c9ce387f515.jpg","https:\/\/doran.id\/wp-content\/uploads\/2024\/09\/Tablet-featured-1.jpg","https:\/\/cdn.idntimes.com\/content-images\/post\/20230426\/rekomendasi-tablet-untuk-menggambar-2023-2-40856973bef50ee8f4a48b23ab469765.png"]', 'Jaya Komputer, Poins Square, Lt. 2, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:13:01', '2026-06-28 15:13:01', 37, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (38, 3, 'Buku Panduan Investasi Saham', 'Stock Investment Guide Book', 'Panduan langkah demi langkah untuk pemula yang ingin memulai investasi di pasar saham.', 'A step-by-step guide for beginners who want to start investing in the stock market.', 165000, 85, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7rasb-m24ztdhrz828ee","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98s-lzxb8r2i817s29","https:\/\/cdn.gramedia.com\/uploads\/product-metas\/p8zpaum93h.png"]', 'Gramedia Matraman, Jl. Matraman Raya, Jakarta Timur, DKI Jakarta', true, '2026-06-28 15:13:02', '2026-06-28 15:13:02', 38, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (39, 4, 'Ikat Pinggang Kulit Pria', 'Men''s Leather Belt', 'Ikat pinggang dari kulit asli dengan kepala gesper metalik yang kokoh dan desain yang maskulin.', 'A genuine leather belt with a sturdy metallic buckle and a masculine design.', 220000, 110, '["https:\/\/down-id.img.susercontent.com\/file\/bec7630cf85e37e6c032fc33137b28ec","https:\/\/i0.wp.com\/www.garvisleather.com\/wp-content\/uploads\/2021\/12\/Ikat-Pinggang-Kulit-Asli.jpg?fit=800%2C800&ssl=1","https:\/\/down-id.img.susercontent.com\/file\/9bc45aa4796af383ca7d25514595aa85"]', 'SOGO Dept. Store, Pakuwon Mall, Surabaya, Jawa Timur', false, '2026-06-28 15:13:02', '2026-06-28 15:13:02', 39, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (40, 5, 'Set Kuas Makeup (12 Pcs)', 'Makeup Brush Set (12 Pcs)', 'Set kuas makeup lengkap dengan bulu sintetis yang lembut, cocok untuk pemula maupun profesional.', 'A complete makeup brush set with soft synthetic bristles, suitable for beginners and professionals.', 195000, 90, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98q-ltaopieifxj132","https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-22110-g3fphbl5zqjv91","https:\/\/cf.shopee.co.id\/file\/sg-11134201-22090-kg5napn6g4hvd8"]', 'Kay Collection, Central Park Mall, Jakarta Barat, DKI Jakarta', true, '2026-06-28 15:13:03', '2026-06-28 15:13:03', 40, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (41, 6, 'Set Dumbbell 10kg', '10kg Dumbbell Set', 'Sepasang dumbbell dengan total berat 10kg (5kg masing-masing), lapisan karet untuk melindungi lantai.', 'A pair of dumbbells with a total weight of 10kg (5kg each), rubber coated to protect floors.', 650000, 40, '["https:\/\/media.4rgos.it\/s\/Argos\/8962449_R_SET?$Main768$&w=620&h=620","https:\/\/pulsefitness.com\/wp-content\/uploads\/2019\/10\/38-040-10kg-Rubber-Covered-Hex.Dumbbells-Free-Weights.jpg","https:\/\/narasport.com\/image\/cache\/catalog\/Narasport%20Helix\/Damb%C4%B1llar\/10%20KG%20dUMBEL-3000x3000.jpg"]', 'Sports Station, Summarecon Mall Serpong, Tangerang, Banten', true, '2026-06-28 15:13:03', '2026-06-28 15:13:03', 41, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (42, 1, 'Ketel Listrik Pemanas Air', 'Electric Water Kettle', 'Ketel listrik berkapasitas 1.7 liter dengan fitur mati otomatis untuk keamanan. Mendidihkan air dengan cepat.', 'A 1.7-liter capacity electric kettle with an auto shut-off feature for safety. Boils water quickly.', 250000, 65, '["https:\/\/cf.shopee.co.id\/file\/7bc99d6c1e8e39648fd2afccfeb303c3","https:\/\/cf.shopee.co.id\/file\/d89690c8e62b895e0ef8a785e5cfd2f3","https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/catalog-image\/101\/MTA-164903419\/no-brand_no-brand_full01.jpg"]', 'Electronic City, SCBD, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:13:04', '2026-06-28 15:13:04', 42, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (43, 1, 'Rok Plisket Midi', 'Pleated Midi Skirt', 'Rok midi model plisket dengan bahan yang jatuh dan pinggang karet yang nyaman. Tampil feminin dan trendi.', 'A pleated midi skirt with a flowy material and a comfortable elastic waistband. Look feminine and trendy.', 280000, 75, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qukw-liyt1ykbkxh795","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98o-lky64z4m4syz28","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98t-lqzwhiodxtjtc2"]', 'Metro Dept. Store, Trans Studio Mall, Bandung, Jawa Barat', false, '2026-06-28 15:13:04', '2026-06-28 15:13:04', 43, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (44, 2, 'Earphone TWS Bass Kuat', 'TWS Earphone Strong Bass', 'True Wireless Stereo earphone dengan koneksi Bluetooth 5.2 dan kualitas suara bass yang mendalam.', 'True Wireless Stereo earphones with Bluetooth 5.2 connection and deep bass sound quality.', 350000, 105, '["https:\/\/images.tokopedia.net\/img\/JFrBQq\/2024\/8\/26\/35dccf3e-5f60-4bcd-a3ad-064f80167909.jpg","https:\/\/cdnus.globalso.com\/foneng\/FONENG-BL136-Product-1-300x300.jpg","hhttps:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r990-lwscl1266ipa87"]', 'Gudang Gadget, Jl. Kaliurang KM 5, Sleman, DIY', true, '2026-06-28 15:13:04', '2026-06-28 15:13:04', 44, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (45, 3, 'Buku Kumpulan Puisi Senja', 'Dusk Poetry Collection Book', 'Sebuah antologi puisi tentang senja, kehilangan, dan harapan. Ditulis oleh penyair ternama.', 'An anthology of poetry about dusk, loss, and hope. Written by a renowned poet.', 85000, 150, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134201-23020-wh2ngme1kvnvae","https:\/\/down-id.img.susercontent.com\/file\/a10dd10a6c7d3f80a8475639435db9cf","https:\/\/tokobuku.sippublishing.co.id\/wp-content\/uploads\/2023\/08\/senja-menjemput-surgamu-1024x1024.jpg"]', 'Kios Buku, Blok M Square, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:13:05', '2026-06-28 15:13:05', 45, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (46, 4, 'Syal Rajut Musim Dingin', 'Winter Knit Scarf', 'Syal tebal dari bahan rajut wol untuk memberikan kehangatan ekstra di musim dingin atau di pegunungan.', 'A thick scarf made from wool knit to provide extra warmth in winter or in the mountains.', 180000, 80, '["https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-22090-mnkwe8ao31hvc7","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r98o-lkxisbw4eh0r6a","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul4-lgj5wevii70b7c"]', 'Pasar Baru Trade Center, Lantai 2, Bandung, Jawa Barat', true, '2026-06-28 15:13:05', '2026-06-28 15:13:05', 46, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (47, 5, 'Parfum Unisex Aroma Kayu', 'Unisex Woody Scent Parfum', 'Parfum dengan wangi utama sandalwood dan cedarwood yang memberikan kesan hangat, elegan, dan natural.', 'A perfume with main notes of sandalwood and cedarwood that gives a warm, elegant, and natural impression.', 450000, 60, '["https:\/\/i5.walmartimages.com\/asr\/52ca9055-b2e2-4426-80f9-5b7489cb2b79.14eeb111f587828473f2d14d404a83f8.jpeg?odnHeight=2000&odnWidth=2000&odnBg=ffffff","https:\/\/cdn.shopify.com\/s\/files\/1\/0632\/2854\/3216\/products\/5.webp?v=1676287754","https:\/\/perfumeland.co.za\/wp-content\/uploads\/2021\/12\/Woody-Ooud-Box.jpg"]', 'C&F Perfumery, 23 Paskal Shopping Center, Bandung, Jawa Barat', false, '2026-06-28 15:13:05', '2026-06-28 15:13:05', 47, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (48, 6, 'Bola Basket Ukuran 7', 'Basketball Size 7', 'Bola basket ukuran standar internasional (ukuran 7) yang terbuat dari bahan karet komposit untuk grip yang maksimal.', 'An international standard size 7 basketball made from composite rubber for maximum grip.', 220000, 50, '["https:\/\/contents.mediadecathlon.com\/p170476\/k$f82a5e9cb3648f191493375a84b50cfd\/sq\/Bal+n+de+baloncesto+GG7X+talla+7+MOLTEN.jpg","https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-22110-9qod13jd3xjv63","https:\/\/ecs7.tokopedia.net\/blog-tokopedia-com\/uploads\/2018\/12\/1.-Teknik-Memegang-Bola-Basket-yang-Benar.jpg"]', 'GOR Saparua, Jl. Saparua No. 2, Bandung, Jawa Barat', true, '2026-06-28 15:13:06', '2026-06-28 15:13:06', 48, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (49, 6, 'Kotak Makan Anti Tumpah', 'Leak-Proof Lunch Box', 'Kotak makan dengan 3 kompartemen dan segel silikon yang rapat untuk menjaga makanan tidak tumpah.', 'A lunch box with 3 compartments and a tight silicone seal to keep food from spilling.', 120000, 130, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul3-lhsua3qp1bb36d","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qul3-liv3dw8p8aznfe","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7qukz-liu7f89258qj69"]', 'Miniso, Jl. Jend. Sudirman No. 45, Yogyakarta, DIY', false, '2026-06-28 15:13:06', '2026-06-28 15:13:06', 49, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (50, 1, 'Kaos Grafis Abstrak', 'Abstract Graphic T-shirt', 'T-shirt katun combed 30s dengan sablon grafis abstrak yang unik dan artistik.', 'A 30s combed cotton T-shirt with a unique and artistic abstract graphic print.', 175000, 250, '["https:\/\/img.freepik.com\/premium-photo\/abstract-graphic-t-shirt-design-with-orange-white-pattern_1346134-8508.jpg?w=1060","http:\/\/www.aoklok.com\/cdn\/shop\/files\/59_10e22eb9-a142-41f1-a813-09e1cf5b38ce_1200x1200.png?v=1692263057","https:\/\/assets.digitalcontent.marksandspencer.app\/image\/upload\/w_1008,h_1319,q_auto,f_auto,e_sharpen\/SD_03_T28_2046M_KY_X_EC_0"]', 'Distro Union, Jl. Sultan Agung No. 12, Bandung, Jawa Barat', true, '2026-06-28 15:13:07', '2026-06-28 15:13:07', 50, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (51, 2, 'Proyektor Mini Portabel', 'Portable Mini Projector', 'Ubah ruangan apa pun menjadi bioskop dengan proyektor portabel yang ringkas dan mudah digunakan ini.', 'Turn any room into a cinema with this compact and easy-to-use portable projector.', 1500000, 30, '["https:\/\/m.media-amazon.com\/images\/I\/51ogSpgsF1L._AC_SL1500_.jpg","https:\/\/m.media-amazon.com\/images\/I\/618klqnYCGL.jpg","https:\/\/i5.walmartimages.com\/asr\/fb7b101a-8a40-47eb-ad52-67a3a91164a2.d4d2b24ca3f71d831c1a03f32b71c2bd.jpeg"]', 'Glodok City, Lantai 3, Jl. Gajah Mada, Jakarta Barat, DKI Jakarta', true, '2026-06-28 15:13:07', '2026-06-28 15:13:07', 51, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (52, 3, 'Novel Sejarah Kerajaan', 'Kingdom Historical Novel', 'Kisah fiksi yang berlatar belakang kerajaan kuno, penuh dengan intrik politik dan pertempuran.', 'A fictional story set in an ancient kingdom, full of political intrigue and battles.', 135000, 95, '["https:\/\/down-my.img.susercontent.com\/file\/b502549d7250870ffad852fc5b4cc267","https:\/\/pictures.abebooks.com\/inventory\/32073273436.jpg","https:\/\/m.media-amazon.com\/images\/I\/71ipUH6yhCL._SL1500_.jpg"]', 'Kampung Buku, Jl. Sumbing No. 3, Malang, Jawa Timur', false, '2026-06-28 15:13:08', '2026-06-28 15:13:08', 52, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (53, 4, 'Syal Sutra Motif', 'Patterned Silk Scarf', 'Syal sutra lembut dengan motif unik yang dapat menambah sentuhan elegan pada penampilan Anda.', 'A soft silk scarf with a unique pattern that can add an elegant touch to your appearance.', 250000, 70, '["https:\/\/www.cheap-neckties.com\/26674-xlarge_default\/persian-print-patterned-silk-scarf-maroon-navy-and-gold-p-23559.jpg","https:\/\/www.bows-n-ties.com\/35443-xlarge_default\/Large-Scale-Persian-Print-Patterned-Silk-Scarf-in-Maroon-Navy-and-Gold.jpg","https:\/\/asset.promod.com\/product\/167829-gz-1704794527.jpg?auto=webp&quality=80"]', 'Alun Alun Indonesia, Grand Indonesia, Jakarta Pusat, DKI Jakarta', true, '2026-06-28 15:13:08', '2026-06-28 15:13:08', 53, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (54, 5, 'Toner Wajah Menenangkan', 'Calming Face Toner', 'Toner yang menghidrasi dan menenangkan kulit sensitif atau kemerahan dengan ekstrak Centella Asiatica.', 'A hydrating toner that soothes sensitive or reddish skin with Centella Asiatica extract.', 160000, 110, '["http:\/\/cdn.shopify.com\/s\/files\/1\/0019\/3603\/1842\/products\/CalmingToner_B2C_RT_Hero_1.png?v=1643391396","https:\/\/shop.lazskincare.com\/cdn\/shop\/products\/FaceRealityCalmToner6oz_SQ_LR.jpg?v=1642360885&width=564","https:\/\/lastingimagefaceandbody.com\/wp-content\/uploads\/2018\/02\/FR-Calming-Facial-Toner-6oz-250x251.jpg"]', 'Klinik Kecantikan Athena, Jl. Sultan Iskandar Muda, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:13:08', '2026-06-28 15:13:08', 54, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (55, 6, 'Raket Badminton Karbon', 'Carbon Badminton Racket', 'Raket ringan dari bahan karbon grafit yang memberikan kekuatan pukulan dan kontrol yang presisi.', 'A lightweight racket made from carbon graphite that provides powerful shots and precise control.', 380000, 55, '["https:\/\/www.mekelin.com\/cdn\/shop\/articles\/Carbon_Fiber_Badminton_Racket.jpg?crop=center&height=1200&v=1695044286&width=1200","https:\/\/images.nexusapp.co\/assets\/3b\/59\/26\/513900114.jpg","https:\/\/img.lazcdn.com\/g\/p\/50c0a4215972733b81449d79079c7f4b.png_720x720q80.png"]', 'Toko Olahraga Champion, Jl. Pajajaran No. 88, Bogor, Jawa Barat', true, '2026-06-28 15:13:09', '2026-06-28 15:13:09', 55, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (56, 4, 'Pemasak Nasi Digital', 'Digital Rice Cooker', 'Pemasak nasi multifungsi yang tidak hanya untuk nasi, tapi juga bisa untuk bubur, sup, dan mengukus.', 'A multifunctional rice cooker that is not only for rice, but also for porridge, soup, and steaming.', 450000, 48, '["https:\/\/images.philips.com\/is\/image\/philipsconsumer\/72a5d444114a427781aaad1e0104aaaf?$jpglarge$&wid=1250","https:\/\/www.parisilk.com\/image\/cache\/data\/1.CHIRAG\/philips\/HD451567%202-500x500.jpg","https:\/\/myredrhino.com\/wp-content\/uploads\/HD4515-4.png"]', 'Best Denki, Central Park Mall, Jakarta Barat, DKI Jakarta', false, '2026-06-28 15:13:09', '2026-06-28 15:13:09', 56, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (57, 1, 'Gaun Pesta Elegan', 'Elegant Party Dress', 'Gaun malam panjang dengan detail payet yang berkilau, membuat Anda menjadi pusat perhatian.', 'A long evening gown with sparkling sequin details, making you the center of attention.', 750000, 25, '["https:\/\/i.etsystatic.com\/21742379\/r\/il\/4534ae\/2228413402\/il_1080xN.2228413402_cryo.jpg","https:\/\/lzd-img-global.slatic.net\/g\/p\/7b3d5ec0d5d76a50f43379d54b531746.jpg_720x720q80.jpg","https:\/\/i.pinimg.com\/originals\/67\/c8\/3d\/67c83d3c5c267644c939e5fa8ccca997.jpg"]', 'Butik Gaun Pesta, Jl. Gunawarman No. 30, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:13:10', '2026-06-28 15:13:10', 57, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (58, 2, 'Smartwatch Pelacak Kebugaran', 'Fitness Tracker Smartwatch', 'Smartwatch yang memonitor detak jantung, langkah, kualitas tidur, dan berbagai mode olahraga.', 'A smartwatch that monitors heart rate, steps, sleep quality, and various sports modes.', 1800000, 40, '["https:\/\/m.media-amazon.com\/images\/I\/61uk6w0AO7L._AC_SL1500_.jpg","https:\/\/m.media-amazon.com\/images\/I\/61Wxr5NdmSL._AC_SL1500_.jpg","https:\/\/m.media-amazon.com\/images\/I\/61uI559urrL._AC_SL1500_.jpg"]', 'Erafone, Jl. Teuku Umar No. 120, Denpasar, Bali', false, '2026-06-28 15:13:10', '2026-06-28 15:13:10', 58, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (59, 3, 'Ensiklopedia Sains Anak', 'Children''s Science Encyclopedia', 'Buku referensi lengkap tentang sains untuk anak-anak, dari luar angkasa hingga dunia mikroba.', 'A complete science reference book for children, from outer space to the microbial world.', 350000, 60, '["https:\/\/www.maplepress.co.in\/cdn\/shop\/files\/9789394668126.MAIN_1200x1200.jpg?v=1706159470","https:\/\/img1.od-cdn.com\/ImageType-400\/2999-1\/4AF\/4C6\/73\/%7B4AF4C673-2752-4B22-807B-9F4577CDB95D%7DImg400.jpg","https:\/\/cdn.dc5.ro\/img-prod\/251037685-0.jpeg"]', 'Penerbit Mizan, Jl. Cinambo No. 135, Bandung, Jawa Barat', true, '2026-06-28 15:13:10', '2026-06-28 15:13:10', 59, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (60, 4, 'Ransel Laptop Anti Maling', 'Anti-Theft Laptop Backpack', 'Ransel dengan ritsleting tersembunyi dan bahan anti-sayat untuk menjaga barang berharga Anda tetap aman.', 'A backpack with hidden zippers and cut-proof material to keep your valuables safe.', 420000, 50, '["https:\/\/m.media-amazon.com\/images\/I\/71rP4MQ9b0L._AC_SL1500_.jpg","https:\/\/m.media-amazon.com\/images\/I\/71oWYl6RnUL._AC_SL1500_.jpg","https:\/\/m.media-amazon.com\/images\/I\/71B27ktrb2L.jpg"]', 'Wellcomm Shop, Botani Square, Bogor, Jawa Barat', false, '2026-06-28 15:13:11', '2026-06-28 15:13:11', 60, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (61, 6, 'Handuk Olahraga Mikrofiber', 'Microfiber Sports Towel', 'Handuk dari bahan mikrofiber yang sangat menyerap keringat dan cepat kering, ringkas untuk dibawa.', 'A towel made from highly absorbent and quick-drying microfiber material, compact to carry.', 195000, 95, '["https:\/\/cf.shopee.co.id\/file\/92490406b180dc40d104c9b894ad34bb","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcSF-E-Vt-b_NJyjR4XXyztDLYHaTz1wEJhuUT2PcyAdNed770wuvzCiCRJLFcLLOCnHU5k&usqp=CAU","https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/\/1129\/mipacko-microfiber_handuk-olahraga-serbaguna--microfiber-30x70_full02.jpg"]', 'Gudang Distribusi, Kawasan Industri Pulogadung, Jakarta Timur, DKI Jakarta', true, '2026-06-28 15:13:11', '2026-06-28 15:13:11', 61, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (62, 6, 'Papan Skateboard Maple', 'Maple Skateboard Deck', 'Papan skateboard yang terbuat dari 7 lapis kayu maple Kanada, memberikan daya tahan dan pop yang luar biasa.', 'A skateboard deck made from 7 layers of Canadian maple wood, providing excellent durability and pop.', 850000, 35, '["https:\/\/assets.bigcartel.com\/product_images\/178266614\/blank-decks-2016.jpg?auto=format&fit=max&w=1200","https:\/\/img.yfisher.com\/m0\/1699489702558-2.jpg","https:\/\/sc04.alicdn.com\/kf\/A511453a620704f78923b9a846b65daceL\/276494911\/A511453a620704f78923b9a846b65daceL.jpg"]', 'Motion Skate Shop, Jl. Kemang Raya No. 10, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:13:11', '2026-06-28 15:13:11', 62, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (63, 3, 'Penggiling Kopi Manual', 'Manual Coffee Grinder', 'Penggiling kopi dengan burr keramik yang dapat disesuaikan untuk tingkat kehalusan gilingan yang konsisten.', 'A coffee grinder with an adjustable ceramic burr for a consistent grind size.', 320000, 50, '["https:\/\/m.media-amazon.com\/images\/I\/61C6xhE4-LS._AC_SL1500_.jpg","https:\/\/i5.walmartimages.com\/asr\/194a6363-f16f-473f-b4c6-b1711421b5f3_1.65b22207680232fc0dd4bacad67e0863.jpeg","https:\/\/images-na.ssl-images-amazon.com\/images\/I\/71jLPBgidkL._SL1500_.jpg"]', 'Otten Coffee, Jl. Pasirkaliki No. 169, Bandung, Jawa Barat', true, '2026-06-28 15:13:12', '2026-06-28 15:13:12', 63, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (64, 1, 'Celana Jeans Sobek (Ripped)', 'Ripped Denim Jeans', 'Celana jeans model slim-fit dengan detail sobek yang trendi untuk gaya kasual yang edgy.', 'Slim-fit jeans with trendy ripped details for an edgy casual style.', 480000, 65, '["https:\/\/i5.walmartimages.com\/seo\/Men-s-Ripped-Jeans-Y2k-Distressed-Destroyed-Straight-Denim-Pants-Streetwear-Skinny-Slim-Fit-Biker-Jeans_6de80804-deac-4e44-aefc-ea9afda7e64a.9c5a670bddf8b01a6387dbf80feacaa1.jpeg","https:\/\/i.pinimg.com\/originals\/87\/09\/e3\/8709e306d9c1772a1690db7df7f03e8f.jpg","https:\/\/i.pinimg.com\/originals\/f5\/7a\/ef\/f57aefef7cc6af20ce22dc133f8ac2f3.jpg"]', 'Jeans Street, Jl. Cihampelas No. 160, Bandung, Jawa Barat', true, '2026-06-28 15:13:12', '2026-06-28 15:13:12', 64, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (65, 2, 'Hard Drive Eksternal 1TB', '1TB External Hard Drive', 'Simpan semua file penting Anda dengan aman di hard drive eksternal berkapasitas 1TB dengan koneksi USB 3.0.', 'Store all your important files safely on this 1TB external hard drive with a USB 3.0 connection.', 900000, 70, '["https:\/\/cdn.shopclues.com\/images\/detailed\/24756\/SeagateBackupPlusSlim1TBExternalHardDisk_1442158976.jpg","https:\/\/www.bhphotovideo.com\/images\/images2500x2500\/Seagate_STAA1000101_FreeAgent_GoFlex_Black_Ultra_Portable_745464.jpg","https:\/\/media.karousell.com\/media\/photos\/products\/2022\/9\/27\/seagate_external_hdd_1tb_1664280479_696e63ff.jpg"]', 'IT Galaxy, Ratu Plaza, Lantai 3, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:13:13', '2026-06-28 15:13:13', 65, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (66, 3, 'Buku Masak Masakan Italia', 'Italian Cuisine Cookbook', 'Pelajari cara membuat pasta, pizza, dan hidangan klasik Italia lainnya langsung dari dapur Anda.', 'Learn how to make pasta, pizza, and other classic Italian dishes right from your own kitchen.', 210000, 80, '["https:\/\/i.pinimg.com\/originals\/2e\/b3\/a2\/2eb3a299c03d9e7d405f8e65cdda4121.jpg","https:\/\/d28hgpri8am2if.cloudfront.net\/book_images\/onix\/cvr9798886740035\/everyday-italian-cookbook-9798886740035_hr.jpg","https:\/\/images-na.ssl-images-amazon.com\/images\/S\/compressed.photo.goodreads.com\/books\/1693524706i\/197769552.jpg"]', 'Books & Beyond, Lippo Mall Kemang, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:13:13', '2026-06-28 15:13:13', 66, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (67, 4, 'Gelang Manik-Manik Etnik', 'Ethnic Beaded Bracelet', 'Gelang tangan handmade dari manik-manik kayu dan batu dengan sentuhan desain etnik yang unik.', 'A handmade bracelet from wood and stone beads with a unique ethnic design touch.', 95000, 120, '["https:\/\/media.urcouple.com\/media\/catalog\/product\/cache\/1\/image\/1000x\/9df78eab33525d08d6e5fb8d27136e95\/b\/r\/br191115415.jpg","https:\/\/i.pinimg.com\/originals\/0f\/a3\/45\/0fa3452d0c30733ee92a61124a1cc2e4.jpg","https:\/\/i.etsystatic.com\/19102727\/r\/il\/c2dcdb\/2617949663\/il_794xN.2617949663_93s3.jpg"]', 'Pasar Seni Sukawati, Gianyar, Bali', false, '2026-06-28 15:13:13', '2026-06-28 15:13:13', 67, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (68, 5, 'Palet Eyeshadow Natural', 'Natural Eyeshadow Palette', 'Palet dengan 12 warna eyeshadow natural (nude & earth tone) yang berpigmen tinggi dan mudah dibaurkan.', 'A palette with 12 highly pigmented and easy-to-blend natural eyeshadow colors (nude & earth tones).', 320000, 75, '["https:\/\/i.pinimg.com\/originals\/1c\/78\/49\/1c7849a63b3fa21b75f1d9708849274e.jpg","http:\/\/ecx.images-amazon.com\/images\/I\/81C3SBD0DlL._SL1500_.jpg","https:\/\/coffeeandmakeup.com\/wp-content\/uploads\/2020\/04\/too-faced-born-this-way-the-natural-nudes-complexion-inspired-eye-shadow-palette-5.jpg"]', 'Beauty Haul, Jl. Wolter Monginsidi No. 5, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:13:14', '2026-06-28 15:13:14', 68, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (69, 6, 'Bola Voli Pantai', 'Beach Volleyball', 'Bola voli yang dirancang khusus untuk permainan di pantai, dengan bahan lembut yang nyaman di tangan.', 'A volleyball specially designed for beach play, with a soft material that is comfortable on the hands.', 180000, 60, '["https:\/\/nwscdn.com\/media\/catalog\/product\/f\/o\/forza_size_5_competition_standard_volleyball_for_all_volleyball_tournaments_and_matches.jpg","https:\/\/thesportsedu.com\/wp-content\/uploads\/2020\/10\/miguel-teirlinck-VDkRsT649C0-unsplash-scaled.jpg","https:\/\/cdn.pixabay.com\/photo\/2016\/08\/24\/14\/17\/beach-volleyball-1617093_1280.jpg"]', 'Toko Olahraga Pantai, Jl. Legian, Kuta, Bali', true, '2026-06-28 15:13:14', '2026-06-28 15:13:14', 69, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (70, 2, 'Set Pisau Dapur Profesional', 'Professional Kitchen Knife Set', 'Set berisi 5 pisau esensial dari baja Jerman yang tajam dan tahan karat, lengkap dengan blok kayu.', 'A set of 5 essential knives made from sharp, rust-resistant German steel, complete with a wooden block.', 550000, 40, '["https:\/\/m.media-amazon.com\/images\/I\/81DtItlIaIL._AC_SL1500_.jpg","https:\/\/cdn-s3.touchofmodern.com\/products\/001\/515\/422\/ee4ad70c7e4db59526c48f57a2039fae_large.jpg?1559348984","https:\/\/m.media-amazon.com\/images\/I\/81N4w+SHXYL._AC_SL1500_.jpg"]', 'Pantry Magic, Jl. Kemang Raya No. 12, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:13:14', '2026-06-28 15:13:14', 70, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (71, 1, 'Jaket Kulit Biker', 'Biker Leather Jacket', 'Jaket kulit asli dengan desain biker klasik, dilengkapi dengan ritsleting metalik yang kuat.', 'A genuine leather jacket with a classic biker design, equipped with strong metallic zippers.', 950000, 30, '["https:\/\/happygentleman.com\/wp-content\/uploads\/2020\/09\/ghost_rider_uclass-black-1.jpg","https:\/\/www.urbanfashionstudio.com\/wp-content\/uploads\/2021\/03\/2-14.jpg","https:\/\/leathermadness.com\/wp-content\/uploads\/Brando_Biker_Black_Leather_Jacket_5__32707-1-1.jpg"]', 'Pusat Kerajinan Kulit, Jl. A.H. Nasution, Garut, Jawa Barat', true, '2026-06-28 15:13:15', '2026-06-28 15:13:15', 71, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (72, 2, 'Monitor Komputer 24 Inci', '24-inch Computer Monitor', 'Monitor IPS Full HD dengan bezel tipis dan refresh rate 75Hz, cocok untuk bekerja dan hiburan.', 'A Full HD IPS monitor with thin bezels and a 75Hz refresh rate, suitable for work and entertainment.', 2500000, 25, '["https:\/\/i5.walmartimages.com\/asr\/0a57d8a9-f7ff-424c-b10e-b628577b0f0a.509c88b784b3031152abee14f17cb792.jpeg","https:\/\/m.media-amazon.com\/images\/I\/71SYhHP5cDL.jpg","https:\/\/m.media-amazon.com\/images\/I\/71QSQwx1+RL._AC_SL1500_.jpg"]', 'Enter Komputer, Mangga Dua Mall, Lantai 5, Jakarta Utara, DKI Jakarta', false, '2026-06-28 15:13:15', '2026-06-28 15:13:15', 72, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (73, 1, 'Stoples Kaca Kedap Udara', 'Airtight Glass Jar', 'Stoples kaca dengan tutup bambu kedap udara untuk menyimpan bumbu dapur, kopi, atau teh agar tetap segar.', 'A glass jar with an airtight bamboo lid to keep your kitchen spices, coffee, or tea fresh.', 75000, 180, '["https:\/\/static.jakmall.id\/2024\/05\/images\/products\/08cb60\/thumbnail\/toples-kaca-kedap-udara-stoples-kue-kering-jar-estetik-950ml-wm-yus641.png","https:\/\/static.jakmall.id\/2025\/01\/images\/products\/60bb63\/thumbnail\/one-two-cups-toples-kaca-penyimpanan-makanan-coffee-storage-glass-jar-hc1019.jpg","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcS_tZCfjMu45JglpMMKWFzzflxvcCpf1CEbVQ&s"]', 'Koleksi Dapur, Jl. Radio Dalam Raya, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:13:16', '2026-06-28 15:13:16', 73, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (74, 4, 'Tas Selempang Kanvas', 'Canvas Messenger Bag', 'Tas selempang dari bahan kanvas yang kuat dengan banyak kantong untuk organisasi yang lebih baik.', 'A durable canvas messenger bag with multiple pockets for better organization.', 310000, 85, '["https:\/\/cdn.shopify.com\/s\/files\/1\/1836\/3413\/products\/canvas-messenger-bags-30624-8_1600x.jpg?v=1652760415","https:\/\/cdn.shopify.com\/s\/files\/1\/1836\/3413\/products\/canvas-messenger-bag-30622-khaki-2_1600x.JPG?v=1527971156","https:\/\/cdn.shopify.com\/s\/files\/1\/1836\/3413\/products\/canvas-messenger-bag-30622-khaki-2_1600x.JPG?v=1527971156"]', 'Eiger Adventure Store, Jl. Sumatera No. 23, Bandung, Jawa Barat', false, '2026-06-28 15:13:16', '2026-06-28 15:13:16', 74, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (75, 5, 'Foundation Cair Full Coverage', 'Full Coverage Liquid Foundation', 'Foundation cair yang memberikan cakupan penuh dan hasil akhir matte yang tahan lama sepanjang hari.', 'A liquid foundation that provides full coverage and a long-lasting matte finish all day.', 275000, 90, '["https:\/\/cdn2.stylecraze.com\/wp-content\/uploads\/product-images\/la-girl-pro-coverage-liquid-foundation-_afl1579.jpg","https:\/\/m.media-amazon.com\/images\/I\/61b-mXtEE-L._SL1500_.jpg","https:\/\/cdn-cf.ipsy.com\/_next\/image?url=https:\/\/cdn-cf.ipsy.com\/contentAsset\/image\/3bcb7b6b-28ce-486f-96ac-194e4561e40c\/fileAsset?byInode=1&w=1920&q=75"]', 'Toko Kosmetik Mahkota, Pasar Baru, Jakarta Pusat, DKI Jakarta', true, '2026-06-28 15:13:16', '2026-06-28 15:13:16', 75, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (76, 6, 'Kacamata Renang Anti Kabut', 'Anti-Fog Swimming Goggles', 'Kacamata renang dengan lensa anti kabut dan perlindungan UV untuk penglihatan yang jernih di dalam air.', 'Swimming goggles with anti-fog lenses and UV protection for clear vision underwater.', 165000, 100, '["https:\/\/placehold.co\/600x400\/0077b6\/ffffff?text=Kacamata","https:\/\/placehold.co\/600x400\/0096c7\/ffffff?text=Lensa","https:\/\/placehold.co\/600x400\/48bfe3\/ffffff?text=Dipakai"]', 'Arena Store, Pondok Indah Water Park, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:13:17', '2026-06-28 15:13:17', 76, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (77, 2, 'Microwave Digital dengan Grill', 'Digital Microwave with Grill', 'Microwave 20 liter dengan fungsi grill tambahan, memudahkan Anda untuk memanaskan dan memanggang.', 'A 20-liter microwave with an additional grill function, making it easy to heat and grill.', 880000, 45, '["https:\/\/www.appliancesdirect.co.uk\/Images\/YCQG302AUB_1_Supersize.jpg?v=3","https:\/\/kokonano.com\/image\/cache\/catalog\/product\/MWM31.000BK-02-800x800.jpg","https:\/\/dukatech.co.ke\/images\/thumbnails\/530\/530\/detailed\/21\/6110f14dd9804_03e5d2fcf5bd7a2bc252508c3440bc23_900x900.jpg"]', 'Toko Sinar Lestari, Jl. Glodok, Jakarta Barat, DKI Jakarta', true, '2026-06-28 15:13:17', '2026-06-28 15:13:17', 77, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (78, 1, 'Set Piyama Katun Jepang', 'Japanese Cotton Pyjama Set', 'Set piyama atasan dan bawahan dari katun jepang yang sangat lembut dan sejuk di kulit.', 'A top and bottom pyjama set made from incredibly soft and cool Japanese cotton.', 295000, 80, '["https:\/\/i.etsystatic.com\/26567353\/r\/il\/d4cf81\/3184700734\/il_1588xN.3184700734_nr5n.jpg","http:\/\/myjapanclothes.com\/cdn\/shop\/files\/japanese-cotton-pajamas_3_1200x1200.jpg?v=1700500414","https:\/\/media1.popsugar-assets.com\/files\/thumbor\/DDBWgsxY735gJNTLlu0GwHcqbLc\/fit-in\/1024x1024\/filters:format_auto-!!-:strip_icc-!!-\/2020\/10\/20\/109\/n\/1922441\/45be3e2d60c8818c_netimgDD34xc\/i\/Cotton-Pajama-Set.jpg"]', 'Uniqlo, Paris Van Java Mall, Bandung, Jawa Barat', false, '2026-06-28 15:13:18', '2026-06-28 15:13:18', 78, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (79, 2, 'Router Wi-Fi Dual Band', 'Dual-Band Wi-Fi Router', 'Router dual-band (2.4GHz & 5GHz) untuk koneksi internet yang lebih cepat dan stabil di seluruh rumah.', 'A dual-band router (2.4GHz & 5GHz) for a faster and more stable internet connection throughout your home.', 650000, 60, '["https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcTNE6JCeyRen36lx-BeUfIfoj1qGn6cFS-CFQ&s","https:\/\/images-na.ssl-images-amazon.com\/images\/I\/71uUF2-2dDL.jpg","https:\/\/images-na.ssl-images-amazon.com\/images\/I\/71kdevTPvGL.jpg"]', 'Dunia Komputer, Jl. Diponegoro No. 132, Surabaya, Jawa Timur', true, '2026-06-28 15:13:18', '2026-06-28 15:13:18', 79, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (80, 3, 'Buku Pengembangan Diri', 'Self-Development Book', 'Buku tentang cara membangun kebiasaan baik dan mencapai tujuan hidup Anda secara efektif.', 'A book on how to build good habits and achieve your life goals effectively.', 145000, 130, '["https:\/\/tse1.mm.bing.net\/th\/id\/OIP.y_KtoTVb-Id_ZZK9FEUaywHaHa?pid=Api&P=0&h=180","https:\/\/i.pinimg.com\/originals\/fb\/b1\/31\/fbb13176da55b25e37210b55a5d67752.png","https:\/\/i.pinimg.com\/originals\/0c\/e5\/59\/0ce559d2d264fefeb266c383ead1892d.png"]', 'Gramedia, Jl. Pandanaran No. 42, Semarang, Jawa Tengah', false, '2026-06-28 15:13:18', '2026-06-28 15:13:18', 80, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (81, 4, 'Rantai Kacamata Manik', 'Beaded Glasses Chain', 'Aksesori rantai kacamata dengan hiasan manik-manik mutiara imitasi yang trendi.', 'A trendy glasses chain accessory with faux pearl bead decorations.', 75000, 150, '["https:\/\/i.etsystatic.com\/22235207\/r\/il\/c6a240\/2343371421\/il_1140xN.2343371421_eqm5.jpg","https:\/\/i.pinimg.com\/originals\/66\/87\/23\/668723598d6b9422ea96f4ff487c82aa.jpg","https:\/\/i.pinimg.com\/originals\/8d\/05\/15\/8d05154d6eef0206affa8fdf766142cd.jpg"]', 'Stradivarius, Beachwalk Shopping Center, Kuta, Bali', true, '2026-06-28 15:13:19', '2026-06-28 15:13:19', 81, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (82, 5, 'Cat Kuku Gel UV', 'UV Gel Nail Polish', 'Cat kuku gel yang harus dikeringkan dengan lampu UV, memberikan hasil akhir super glossy dan tahan lama.', 'A gel nail polish that must be cured with a UV lamp, providing a super glossy and long-lasting finish.', 95000, 120, '["https:\/\/weheartnails.com\/wp-content\/uploads\/2018\/09\/61UtaKSiNL._SL1000_-1024x1024.jpg","https:\/\/weheartnails.com\/wp-content\/uploads\/2018\/09\/51JJ8xPT09L._SL1001_-1024x1024.jpg","https:\/\/m.media-amazon.com\/images\/I\/81-4GBPHHcL._AC_SL1500_.jpg"]', 'Toko Perlengkapan Salon, Pasar Pagi Mangga Dua, Jakarta Utara, DKI Jakarta', false, '2026-06-28 15:13:19', '2026-06-28 15:13:19', 82, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (83, 6, 'Matras Pilates Tebal', 'Thick Pilates Mat', 'Matras ekstra tebal (10mm) untuk kenyamanan maksimal saat melakukan pilates atau senam lantai.', 'An extra-thick (10mm) mat for maximum comfort during pilates or floor exercises.', 320000, 70, '["https:\/\/www.shape.com\/thmb\/Xzxk7i7Ddp_0AJWlp_SMJs7FMZw=\/fit-in\/1500x1000\/filters:no_upscale():max_bytes(150000):strip_icc()\/stott-pilates-deluxe-pilates-mat-bc3c67b95f6d4619824003cf061ba890.jpg","https:\/\/i5.walmartimages.com\/asr\/14de210a-3b8a-4adb-8b24-dd02a9736b83_1.f92602865032cd08bc52aaad90ca60a1.jpeg","https:\/\/m.media-amazon.com\/images\/I\/71z6+uaM2VL._SL1500_.jpg"]', 'Celebrity Fitness, FX Sudirman, Jakarta Pusat, DKI Jakarta', true, '2026-06-28 15:13:20', '2026-06-28 15:13:20', 83, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (84, 1, 'Papan Talenan Kayu Jati', 'Teak Wood Cutting Board', 'Talenan besar dari kayu jati solid yang kokoh, tidak mudah tergores dan aman untuk pisau.', 'A large and sturdy solid teak wood cutting board, scratch-resistant and knife-friendly.', 180000, 90, '["https:\/\/d332p1w15mxdmm.cloudfront.net\/proteak-medium-edge-grain-teak-cutting-board-20-x-15-58a3732677ff4.jpg","https.d332p1w15mxdmm.cloudfront.net\/proteak-medium-edge-grain-teak-cutting-board-20-x-15-58a373017bea2.jpg","https:\/\/images1.novica.net\/pictures\/9\/p373890_2.jpg"]', 'Pengrajin Kayu Jepara, Jl. Tahunan, Jepara, Jawa Tengah', false, '2026-06-28 15:13:20', '2026-06-28 15:13:20', 84, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (85, 1, 'Sweater Rajut Turtleneck', 'Turtleneck Knit Sweater', 'Sweater turtleneck dari bahan rajut wol yang hangat dan lembut, cocok untuk cuaca dingin.', 'A warm and soft wool knit turtleneck sweater, perfect for cold weather.', 450000, 60, '["https:\/\/content.propertyroom.com\/listings\/sellers\/seller600031\/images\/origimgs\/600031_291202301933121.jpg","https:\/\/www.rossignol.com\/dw\/image\/v2\/BJJZ_PRD\/on\/demandware.static\/-\/Sites-rossignol-catalog\/default\/dwfbab7259\/images\/large\/RLLWO08_100_rgb72dpi_05.jpg?sw=1200&sh=1200","https:\/\/images.garmentory.com\/images\/885385\/xl\/Harmony-Grey-Windy-Turtleneck-Knit-Sweater-20171030014703.jpg?1509328026"]', 'Pusat Rajut Binong Jati, Bandung, Jawa Barat', true, '2026-06-28 15:13:20', '2026-06-28 15:13:20', 85, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (86, 2, 'Tripod Kamera Fleksibel', 'Flexible Camera Tripod', 'Tripod dengan kaki-kaki fleksibel yang bisa dililitkan di mana saja. Cocok untuk kamera dan smartphone.', 'A tripod with flexible legs that can be wrapped anywhere. Suitable for cameras and smartphones.', 350000, 55, '["https:\/\/m.media-amazon.com\/images\/S\/aplus-media\/mg\/fcad5e33-369f-4f40-a773-de14360bea2e.jpg","https:\/\/images-na.ssl-images-amazon.com\/images\/I\/61kMm8GLWyL._SL1118_.jpg","https:\/\/i5.walmartimages.com\/asr\/e2e1607c-92f8-45cd-861b-b1e83fda9bb3.9c69b131a8a9fcb7f9eec3b005dc7854.jpeg?odnWidth=1000&odnHeight=1000&odnBg=ffffff"]', 'Toko Kamera Focus Nusantara, Jl. Panglima Polim, Jakarta Selatan, DKI Jakarta', false, '2026-06-28 15:13:21', '2026-06-28 15:13:21', 86, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (87, 3, 'Buku Dongeng Anak Bergambar', 'Illustrated Children''s Fairy Tale Book', 'Kumpulan dongeng klasik dunia yang diceritakan kembali dengan ilustrasi modern yang menarik bagi anak.', 'A collection of classic world fairy tales retold with engaging modern illustrations for children.', 110000, 140, '["https:\/\/i.etsystatic.com\/9743954\/r\/il\/01224e\/3982398881\/il_fullxfull.3982398881_kq1r.jpg","https:\/\/i.pinimg.com\/originals\/bd\/33\/13\/bd331359a2567a189d6b6f1833bbac02.jpg","https:\/\/i.pinimg.com\/originals\/55\/05\/a5\/5505a5cadad9b1c40a731120ab123204.jpg"]', 'Kinokuniya, Plaza Senayan, Jakarta Pusat, DKI Jakarta', true, '2026-06-28 15:13:21', '2026-06-28 15:13:21', 87, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (88, 4, 'Ikat Rambut Sutra (Scrunchie)', 'Silk Hair Scrunchie', 'Scrunchie dari bahan sutra satin yang lembut untuk mencegah rambut kusut dan patah.', 'A scrunchie made from soft satin silk to prevent tangled and broken hair.', 80000, 200, '["https:\/\/i.pinimg.com\/originals\/44\/cd\/48\/44cd48ffdf43cd66f42864ff3d008420.jpg","https:\/\/i.etsystatic.com\/25807579\/r\/il\/824f5e\/2949315264\/il_1080xN.2949315264_p0e4.jpg","https:\/\/m.media-amazon.com\/images\/I\/71OjDJOgyqL._SL1500_.jpg"]', 'Pusat Aksesoris Asemka, Jakarta Barat, DKI Jakarta', false, '2026-06-28 15:13:21', '2026-06-28 15:13:21', 88, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (89, 5, 'Pembersih Wajah Lembut', 'Gentle Face Cleanser', 'Sabun pembersih wajah dengan pH seimbang yang membersihkan kotoran tanpa membuat kulit terasa kering.', 'A pH-balanced facial cleanser that removes dirt without making the skin feel dry.', 140000, 110, '["https:\/\/m.media-amazon.com\/images\/I\/61M4TsXbYLL._SL1500_.jpg","https:\/\/m.media-amazon.com\/images\/I\/51SBvxJG0WL._SL1200_.jpg","https:\/\/m.media-amazon.com\/images\/I\/71prJMq3W5L._SL1500_.jpg"]', 'Century Healthcare, Jl. Raya Kuta No. 88, Bali', true, '2026-06-28 15:13:22', '2026-06-28 15:13:22', 89, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (90, 6, 'Tas Gym Tahan Air', 'Waterproof Gym Bag', 'Tas gym dengan kompartemen terpisah untuk sepatu dan pakaian basah. Terbuat dari bahan tahan air.', 'A gym bag with separate compartments for shoes and wet clothes. Made from waterproof material.', 420000, 60, '["http:\/\/www.allfashionbags.com\/wp-content\/uploads\/2019\/09\/Large-Waterproof-Gym-Bag.jpg","https:\/\/i.pinimg.com\/736x\/79\/c0\/20\/79c020baa10cedeec67a120b9c96e730.jpg","https:\/\/images-na.ssl-images-amazon.com\/images\/I\/61ha1d--xLL.jpg"]', 'Athlete''s Foot, Galaxy Mall, Surabaya, Jawa Timur', false, '2026-06-28 15:13:22', '2026-06-28 15:13:22', 90, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (91, 1, 'Wajan Penggorengan Dalam', 'Deep Frying Pan (Wok)', 'Wajan penggorengan dalam dengan lapisan anti-lengket, cocok untuk menumis dan menggoreng.', 'A deep frying pan (wok) with a non-stick coating, suitable for stir-frying and deep-frying.', 190000, 80, '["https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcRM30WEPVn1DXBmARqrT_euW-_7wqCqZUxSPA&s","https:\/\/s.alicdn.com\/@sc04\/kf\/H0fccc87f7db9485ea1d09830f98dbf545.jpg","https:\/\/images.tokopedia.net\/img\/cache\/200-square\/VqbcmM\/2024\/7\/30\/6f6e30d6-8451-48d5-8a27-9dcf106c6e2f.jpg"]', 'Toko Perabot Laris, Jl. Urip Sumoharjo, Makassar, Sulawesi Selatan', true, '2026-06-28 15:13:23', '2026-06-28 15:13:23', 91, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (92, 1, 'Polo Shirt Berkerah', 'Collared Polo Shirt', 'Polo shirt dari bahan katun pique yang adem dengan detail kerah dan kancing yang klasik.', 'A cool pique cotton polo shirt with classic collar and button details.', 320000, 70, '["https:\/\/down-id.img.susercontent.com\/file\/8c8d895efab3302579753da07d72b9d9","https:\/\/moko.co.id\/wp-content\/uploads\/2017\/01\/polo-shirt-zipper-white-blue-a-moko-konveksi.jpg","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcS7Q_wVa0e4jF-yYuRv_bWXWMXaYyS8In67yw&s"]', 'Polo Ralph Lauren, Plaza Indonesia, Jakarta Pusat, DKI Jakarta', true, '2026-06-28 15:13:23', '2026-06-28 15:13:23', 92, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (93, 2, 'Mousepad Gaming XXL', 'XXL Gaming Mousepad', 'Mousepad ukuran ekstra besar yang dapat menampung keyboard dan mouse, dengan permukaan kain yang halus.', 'An extra-large mousepad that can accommodate a keyboard and mouse, with a smooth cloth surface.', 180000, 90, '["https:\/\/i.etsystatic.com\/32627543\/r\/il\/15d62d\/4196137793\/il_fullxfull.4196137793_dkwl.jpg","https:\/\/m.media-amazon.com\/images\/I\/71+tpMSBaCS._AC_SL1000_.jpg","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcS1zEUkHUtMPZgyrUyMCKUvPW4N7J_Sd-ov8g&s"]', 'Quantum Computer, Jogjatronik Mall, Lantai 2, Yogyakarta, DIY', false, '2026-06-28 15:13:23', '2026-06-28 15:13:23', 93, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (94, 3, 'Buku Catatan Kulit Jurnal', 'Leather Journal Notebook', 'Buku catatan dengan sampul kulit sintetis yang elegan, cocok untuk jurnal, sketsa, atau catatan harian.', 'An elegant synthetic leather cover notebook, suitable for journaling, sketching, or daily notes.', 195000, 100, '["https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcSjfAs7yMGD4DTY9Gl8IRvtjHrk8BNFLG3vOw&s","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcTQ4cOKK58qR5CNOMwFfbNOCMbpf7rCoKhzUg&s","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcQJrBUHCcvA2CEUx-CSh1xEIzzJlYYEJ3UG-w&s"]', 'Typo, Kota Kasablanka, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:13:24', '2026-06-28 15:13:24', 94, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (95, 4, 'Gantungan Kunci Kulit', 'Leather Keychain', 'Gantungan kunci minimalis dari kulit asli dengan pengait metal yang kuat dan tahan lama.', 'A minimalist keychain made from genuine leather with a strong and durable metal hook.', 125000, 110, '["https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcSuDBXOLw8QoRTuFabVz0EEXC6uGr_AzEWb9Q&s","https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/\/catalog-image\/101\/MTA-141691952\/brd-44261_gantungan-kunci-kulit-sapi-asli-crazy-horse-premium-leathers_full01-b32b8202.jpg","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcT5Sd-oMrhwDgKJQls9_CLoDdKmQ5IZcVPuzg&s"]', 'Workshop Kulit, Jl. Malioboro No. 99, Yogyakarta, DIY', false, '2026-06-28 15:13:24', '2026-06-28 15:13:24', 95, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (96, 5, 'Masker Tidur (Sleeping Mask)', 'Sleeping Mask', 'Masker wajah yang digunakan semalaman untuk memberikan hidrasi intensif dan membuat kulit kenyal di pagi hari.', 'An overnight face mask that provides intensive hydration, leaving the skin supple in the morning.', 99000, 140, '["https:\/\/upload.jaknot.com\/2023\/06\/images\/products\/82f5f1\/original\/voguish-masker-tidur-penutup-mata-sleeping-mask-1022.jpeg","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcSjLS-bIl15EWNcGIuZslamxpWRnsvlzDNiAA&s","https:\/\/images-cdn.ubuy.co.in\/663a62032fdad25fc52e26b3-yfong-weighted-sleep-mask-women-men-3d.jpg"]', 'The Body Shop, Ambarrukmo Plaza, Sleman, DIY', true, '2026-06-28 15:13:25', '2026-06-28 15:13:25', 96, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (98, 3, 'Spatula Silikon Set', 'Silicone Spatula Set', 'Set spatula silikon tahan panas yang aman untuk peralatan masak anti-lengket Anda.', 'A heat-resistant silicone spatula set that is safe for your non-stick cookware.', 95000, 100, '["https:\/\/id-test-11.slatic.net\/p\/2cdd66a4576a42a6414624d74e7a0638.jpg","https:\/\/down-id.img.susercontent.com\/file\/79536b6a73f4f8872a753d5b3251507e","https:\/\/s.alicdn.com\/@sc04\/kf\/H459f4de988e74d3abf71304d9fac1281u.jpg"]', 'Toko Bahan Kue, Jl. Mayjend Sungkono No. 88, Surabaya, Jawa Timur', true, '2026-06-28 15:13:25', '2026-06-28 15:13:25', 98, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (100, 2, 'Docking Station USB-C', 'USB-C Docking Station', 'Perluas konektivitas laptop Anda dengan docking station ini (port HDMI, USB 3.0, Card Reader).', 'Expand your laptop''s connectivity with this docking station (HDMI, USB 3.0 ports, Card Reader).', 450000, 70, '["https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcQdLO_PDrqRRQHkmzpXOgZr-XCBsgRiJnJjaw&s","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcTY2dcFfnge2D22imL2aSAsSW8zeAZay6MjZw&s","https:\/\/m.media-amazon.com\/images\/I\/71czw12TGJL.jpg"]', 'KliknKlik, Ratu Plaza, Lantai 1, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:13:26', '2026-06-28 15:13:26', 100, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (101, 3, 'Buku Mewarnai Dewasa', 'Adult Coloring Book', 'Hilangkan stres dengan buku mewarnai untuk dewasa yang berisi pola-pola rumit dan menenangkan.', 'Relieve stress with this adult coloring book filled with intricate and calming patterns.', 125000, 110, '["https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcQSE-U9YIYjYDPncrG8RVSIIlVaClP_m-OEEw&s","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7rbk9-m9cp941p4gl7da","https:\/\/images.tokopedia.net\/img\/cache\/200-square\/VqbcmM\/2024\/6\/1\/1a8e29f9-6391-4860-bd1c-a3d7b8ba71fb.jpg?ect=4g"]', 'Toko Buku Eureka, Jl. C. Simanjuntak No. 10, Yogyakarta, DIY', false, '2026-06-28 15:13:27', '2026-06-28 15:13:27', 101, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (102, 4, 'Pin Enamel Karakter Lucu', 'Cute Character Enamel Pin', 'Pin enamel untuk menghias tas, jaket, atau papan Anda dengan berbagai desain karakter yang lucu.', 'An enamel pin to decorate your bag, jacket, or board with various cute character designs.', 115000, 130, '["https:\/\/image.made-in-china.com\/318f0j00paLRFDlIvVcP\/Pin-5-mp4.webp","https:\/\/down-id.img.susercontent.com\/file\/sg-11134201-22120-ng6q49aigplvf1","https:\/\/ae01.alicdn.com\/kf\/H37d39c19b1e94fa2b501dc8327a88359M.jpg"]', 'M Bloc Market, Jl. Sisingamangaraja, Jakarta Selatan, DKI Jakarta', true, '2026-06-28 15:13:27', '2026-06-28 15:13:27', 102, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (103, 5, 'Cermin Rias Meja', 'Desk Makeup Mirror', 'Cermin dua sisi (normal dan pembesaran 3x) dengan penyangga yang stabil untuk meja rias Anda.', 'A double-sided mirror (normal and 3x magnification) with a stable stand for your vanity table.', 85000, 160, '["https:\/\/www.indofurnia.com\/wp-content\/uploads\/2020\/08\/Meja-Rias-Kaca-Minimalis-Ktaxon-Cantik-scaled.jpeg","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r991-ly3321dlfbje44","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7r991-ls28nyuclkux0d"]', 'Toko Kaca & Cermin, Jl. ABC, Bandung, Jawa Barat', false, '2026-06-28 15:13:27', '2026-06-28 15:13:27', 103, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (99, 1, 'Blus Wanita Lengan Lonceng', 'Women''s Bell Sleeve Blouse', 'Blus cantik dengan detail lengan lonceng yang memberikan sentuhan gaya bohemian.', 'A beautiful blouse with bell sleeve details that provides a touch of bohemian style.', 250000, 89, '["https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcQfqrgxfmLzm5P8ZG0xAJADYjf-OuTJ77SU6w&s","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcQ9Dik2-GGCxoH0zqop5zDAfG7PUGFDioox7w&s","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcR7OPOsqPLpGmyfmTt7aZV3ke-SfQjvQRgD1w&s"]', 'Mango, Deli Park Mall, Medan, Sumatera Utara', false, '2026-06-28 15:13:26', '2026-06-29 04:12:15', 99, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (104, 2, 'Toples Penyimpanan Makanan', 'Food Storage Jar Set', 'Set toples kaca kedap udara untuk menjaga kesegaran bumbu, kopi, dan makanan ringan Anda lebih lama.', 'Airtight glass jar set to keep your spices, coffee, and snacks fresh for longer.', 150000, 120, '["https:\/\/static.jakmall.id\/2022\/11\/images\/products\/fec3ab\/detail\/lism-toples-wadah-penyimpanan-makanan-food-storage-container-h1212.jpg","https:\/\/upload.jaknot.com\/2022\/12\/images\/products\/dee51d\/original\/internaul-toples-kaca-penyimpanan-makanan-bamboo-cover-ys-7061.jpg","https:\/\/images.tokopedia.net\/img\/cache\/500-square\/VqbcmM\/2024\/4\/19\/3d276636-b66d-4de5-a45f-d12813faefe4.jpg"]', 'Daiso, AEON Mall BSD City, Tangerang, Banten', false, '2026-06-28 15:13:28', '2026-06-28 15:13:28', 104, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (107, 2, 'Kaus Katun Premium', 'Premium Cotton T-shirt', 'Kaus Katun Premium', 'Premium Cotton T-shirt', 230000, 50, '["products\/6iZE9MOrf83tTJlOPVglXP5Gs9Sxv1GsfhWealXB.jpg"]', 'Toko Online', false, '2026-06-28 15:19:04', '2026-06-28 15:19:04', 106, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (3, 4, 'Tas Ransel Harian', 'Daily Backpack', 'Tas ransel ringan dengan banyak kompartemen, termasuk slot laptop 14 inci. Cocok untuk sekolah atau bekerja.', 'A lightweight backpack with multiple compartments, including a 14-inch laptop slot. Perfect for school or work.', 350000, 49, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134201-23020-fbf6gazk4lnv89","https:\/\/down-id.img.susercontent.com\/file\/20aa1e12586128d5eac540130867b28e","https:\/\/img.lazcdn.com\/g\/p\/d7c903b488a059d23118533f61b50a51.jpg_720x720q80.jpg"]', 'Gudang Produksi, Jl. Tajur No. 21, Bogor, Jawa Barat', true, '2026-06-28 15:12:47', '2026-06-29 03:32:46', 3, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (1, 1, 'Jaket Denim Klasik', 'Classic Denim Jacket', 'Jaket denim timeless dengan potongan reguler. Terbuat dari bahan denim tebal yang nyaman dan tahan lama.', 'A timeless denim jacket with a regular fit cut. Made from thick, comfortable, and durable denim material.', 525000, 35, '["https:\/\/down-id.img.susercontent.com\/file\/id-11134201-7r98x-lra9o8b96r1y38","https:\/\/down-id.img.susercontent.com\/file\/69e44947b0794c8743f3cd86658c229d","https:\/\/konveksidiamond.com\/wp-content\/uploads\/2023\/02\/Jaket-denim-jogja.jpeg"]', 'Jl. Cibaduyut Raya No. 140, Bandung, Jawa Barat', true, '2026-06-28 15:12:47', '2026-06-30 04:04:37', 1, 'baru', 1000, NULL, true, 15000, '2026-06-29 04:04:37', '2026-07-02 04:04:37', 50);
INSERT INTO public.products VALUES (4, 3, 'Buku Resep Masakan Nusantara', 'Archipelago Cuisine Recipe Book', 'Kumpulan 100 resep masakan otentik dari berbagai daerah di Indonesia. Dilengkapi dengan gambar full-color.', 'A collection of 100 authentic recipes from various regions in Indonesia. Complemented with full-color pictures.', 225000, 80, '["https:\/\/tse1.mm.bing.net\/th\/id\/OIP.6ppZVP3IZr3QsWgkLWZ7LwHaJ4?pid=Api&P=0&h=180","https:\/\/tse3.mm.bing.net\/th\/id\/OIP.AGERaE29g9w8RWJzx27QWAHaJs?pid=Api&P=0&h=180","https:\/\/down-id.img.susercontent.com\/file\/8fa587915abcb3fbd0d9c1067514d8ed"]', 'Toko Buku Gramedia, Jl. Margonda Raya No. 42, Depok, Jawa Barat', false, '2026-06-28 15:12:48', '2026-06-30 04:04:37', 4, 'baru', 1000, NULL, true, 15000, '2026-06-29 04:04:37', '2026-07-02 04:04:37', 50);
INSERT INTO public.products VALUES (5, 5, 'Serum Pencerah Wajah', 'Brightening Face Serum', 'Serum dengan kandungan Vitamin C dan Niacinamide untuk membantu mencerahkan kulit dan menyamarkan noda hitam.', 'A serum with Vitamin C and Niacinamide to help brighten the skin and reduce dark spots.', 185000, 45, '["https:\/\/img.lazcdn.com\/g\/ff\/kf\/S5579a04db43a4ee8a45048c4d09baee24.jpg_720x720q80.jpg","https:\/\/down-id.img.susercontent.com\/file\/233bcb88d43cf805f58a9bdd443c8c03","https:\/\/down-id.img.susercontent.com\/file\/id-11134207-7rash-m1r3td5jt7smd1"]', 'Distributor Utama, Jl. Pucang Anom Timur II No. 3, Surabaya, Jawa Timur', true, '2026-06-28 15:12:48', '2026-06-30 04:04:37', 5, 'baru', 1000, NULL, true, 15000, '2026-06-29 04:04:37', '2026-07-02 04:04:37', 50);
INSERT INTO public.products VALUES (105, 2, 'Kipas Angin Meja', 'Desk Fan', 'Kipas angin meja 12 inci dengan tiga pilihan kecepatan dan fitur osilasi untuk menyebarkan udara sejuk merata.', 'A 12-inch desk fan with three speed options and an oscillation feature to distribute cool air evenly.', 250000, 59, '["https:\/\/ecs7.tokopedia.net\/img\/cache\/700\/product-1\/2019\/2\/13\/1687614\/1687614_ba29a1f1-b0b8-4222-bd6d-0070b077e2a2_800_800.jpg","https:\/\/down-id.img.susercontent.com\/file\/7a5d0a76a1dff5db7ee0117051529b40","https:\/\/www.static-src.com\/wcsstore\/Indraprastha\/images\/catalog\/full\/668\/sekai_kipas-angin-meja-sekai-fcu-835_full02.jpg"]', 'Toko Elektronik ABC, Jl. Pahlawan No. 99, Palembang, Sumatera Selatan', true, '2026-06-28 15:13:28', '2026-06-30 05:24:54', 105, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (97, 6, 'Celana Training Jogger', 'Jogger Training Pants', 'Celana training model jogger dari bahan fleece yang nyaman, cocok untuk olahraga atau santai.', 'Jogger-style training pants made from comfortable fleece material, suitable for sports or leisure.', 350000, 79, '["https:\/\/down-id.img.susercontent.com\/file\/686195cbfbf01330ba9f9a40170bcf4a","https:\/\/encrypted-tbn0.gstatic.com\/images?q=tbn:ANd9GcSkqduuZdnHFKwjnOTcOT-vKwAWct4X4pPso5L41YBuTr9b0yqLf7UDId2_GGTnmQRikLE&usqp=CAU","https:\/\/bimg.akulaku.net\/goods\/spu\/e4d574f40d10418a860531d8789c9bc99848.jpg?w=726&q=80&fit=1"]', 'Adidas Store, 23 Paskal Shopping Center, Bandung, Jawa Barat', false, '2026-06-28 15:13:25', '2026-06-30 05:24:54', 97, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);
INSERT INTO public.products VALUES (106, 6, 'Kabel', 'Cable', 'Kipas angin meja 12 inci dengan tiga pilihan kecepatan dan fitur osilasi untuk menyebarkan udara sejuk merata.', 'A 12-inch desk fan with three speed options and an oscillation feature to distribute cool air evenly.', 1000, 49, '["assets\/products\/product-1.jpg","assets\/products\/product-1.jpg"]', 'Toko Elektronik ABC, Jl. Pahlawan No. 99, Palembang, Sumatera Selatan', true, '2026-06-28 15:13:29', '2026-06-30 05:25:26', 105, 'baru', 1000, NULL, false, NULL, NULL, NULL, NULL);


--
-- TOC entry 5262 (class 0 OID 67452)
-- Dependencies: 243
-- Data for Name: reviews; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.reviews VALUES (1, 106, 3, 1, 5, 'mantap', NULL, '2026-06-29 04:10:19', '2026-06-29 04:10:19');


--
-- TOC entry 5243 (class 0 OID 67243)
-- Dependencies: 224
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.sessions VALUES ('gSGt3qGCd7wBU2ronvkfizftvQDc28FbD4HPgah9', 106, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaEtZdEJaOWhPTWNmWFFjbHl5c1lMUE9nWlh1YWJCWFBzM3hpT0wweSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXJ0IjtzOjU6InJvdXRlIjtzOjEwOiJjYXJ0LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA2O3M6MTM6Imxhc3Rfb3JkZXJfaWQiO2k6ODt9', 1782797837);


--
-- TOC entry 5272 (class 0 OID 67587)
-- Dependencies: 253
-- Data for Name: settings; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5241 (class 0 OID 67220)
-- Dependencies: 222
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES (1, 'Jl. Cibaduyut Raya No. 140', 'jl.cibaduyutrayano.140@seller.minecart.test', NULL, '$2y$12$lo6IOkpFXODG/PBbJ1/XsOeXOa6QwmtnKvFjoPSxRNHAX9xf6BYZi', NULL, '2026-06-28 15:12:47', '2026-06-28 15:12:47', '0800000000', 'Jl. Cibaduyut Raya No. 140, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Jl. Cibaduyut Raya No. 140', NULL, 'user', 'active');
INSERT INTO public.users VALUES (2, 'Harco Mangga Dua', 'harcomanggadua@seller.minecart.test', NULL, '$2y$12$GaxeCN3BzOKmeVuw25sxWex0nf/o8jiS7ODHP0siD7pH.YcsW049a', NULL, '2026-06-28 15:12:47', '2026-06-28 15:12:47', '0800000000', 'Harco Mangga Dua, Lantai 3, Blok B No. 5, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Harco Mangga Dua', NULL, 'user', 'active');
INSERT INTO public.users VALUES (3, 'Gudang Produksi', 'gudangproduksi@seller.minecart.test', NULL, '$2y$12$Ky01ifY8DNtsX.mJmtxidO/7GdMIFZh1Bm8LfOgQ.l6F6pPhqe6tC', NULL, '2026-06-28 15:12:47', '2026-06-28 15:12:47', '0800000000', 'Gudang Produksi, Jl. Tajur No. 21, Bogor, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Gudang Produksi', NULL, 'user', 'active');
INSERT INTO public.users VALUES (4, 'Toko Buku Gramedia', 'tokobukugramedia@seller.minecart.test', NULL, '$2y$12$Wow9BdJfBV3V8SZTH.0h5enMXz.fd/4LEM31PwopmnGDvLkGjIgxu', NULL, '2026-06-28 15:12:48', '2026-06-28 15:12:48', '0800000000', 'Toko Buku Gramedia, Jl. Margonda Raya No. 42, Depok, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Buku Gramedia', NULL, 'user', 'active');
INSERT INTO public.users VALUES (5, 'Distributor Utama', 'distributorutama@seller.minecart.test', NULL, '$2y$12$/Cb//sKJSebpv6BE1TNxge8Y3cKmuJ5IuhCiiN3WHP/nSiXL2xY5u', NULL, '2026-06-28 15:12:48', '2026-06-28 15:12:48', '0800000000', 'Distributor Utama, Jl. Pucang Anom Timur II No. 3, Surabaya, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'Distributor Utama', NULL, 'user', 'active');
INSERT INTO public.users VALUES (6, 'Pusat Grosir Olahraga', 'pusatgrosirolahraga@seller.minecart.test', NULL, '$2y$12$fu8koAdMJFaj9j57k1CoXuyE1ymbMqHX0R4sk4jJKxpPxLMvxbsuy', NULL, '2026-06-28 15:12:49', '2026-06-28 15:12:49', '0800000000', 'Pusat Grosir Olahraga, Jl. Cihampelas No. 98, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Pusat Grosir Olahraga', NULL, 'user', 'active');
INSERT INTO public.users VALUES (7, 'Toko Peralatan Kopi', 'tokoperalatankopi@seller.minecart.test', NULL, '$2y$12$Z7WJtc78UL233h3fsCHB6OCrKGXPdPMb98eiruGzlbgyaEvLCri.m', NULL, '2026-06-28 15:12:49', '2026-06-28 15:12:49', '0800000000', 'Toko Peralatan Kopi, Jl. Senopati No. 64, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Peralatan Kopi', NULL, 'user', 'active');
INSERT INTO public.users VALUES (8, 'Factory Outlet', 'factoryoutlet@seller.minecart.test', NULL, '$2y$12$8mZ0wfKLoYiUy23/GutftOZQTPh7h.7RlJTZh/1zlDvs1uyRfbarG', NULL, '2026-06-28 15:12:49', '2026-06-28 15:12:49', '0800000000', 'Factory Outlet, Jl. R.E. Martadinata No. 55, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Factory Outlet', NULL, 'user', 'active');
INSERT INTO public.users VALUES (9, 'Mal Ambassador', 'malambassador@seller.minecart.test', NULL, '$2y$12$Durbiq12C.ofts/Fdg0l.OQZN4BsGTPcju.TyQhjuzWjTRdmGQH12', NULL, '2026-06-28 15:12:50', '2026-06-28 15:12:50', '0800000000', 'Mal Ambassador, Lantai 2, Jl. Prof. DR. Satrio, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Mal Ambassador', NULL, 'user', 'active');
INSERT INTO public.users VALUES (10, 'Toko Buku Togamas', 'tokobukutogamas@seller.minecart.test', NULL, '$2y$12$vLal6wnkiwUCK2xdMjjMv.nxs5FKkL99S5rf2wxb/itClD.fbMO4u', NULL, '2026-06-28 15:12:50', '2026-06-28 15:12:50', '0800000000', 'Toko Buku Togamas, Jl. Affandi No. 5, Yogyakarta, DIY', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Buku Togamas', NULL, 'user', 'active');
INSERT INTO public.users VALUES (11, 'Plaza Senayan', 'plazasenayan@seller.minecart.test', NULL, '$2y$12$10ae2lUMciOpLknC4pisEO8C9pne0KZC7X9cYbiwvolxxKuJ2aYT2', NULL, '2026-06-28 15:12:50', '2026-06-28 15:12:50', '0800000000', 'Plaza Senayan, Lantai 1, Jl. Asia Afrika, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Plaza Senayan', NULL, 'user', 'active');
INSERT INTO public.users VALUES (12, 'Watsons', 'watsons@seller.minecart.test', NULL, '$2y$12$BG2edbbmSQOTS8vf/vh9x.jJQC0ODBaAmMINEnQit5zxibYg/7ln6', NULL, '2026-06-28 15:12:51', '2026-06-28 15:12:51', '0800000000', 'Watsons, Tunjungan Plaza 3, Surabaya, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'Watsons', NULL, 'user', 'active');
INSERT INTO public.users VALUES (13, 'Toko Olahraga Jaya', 'tokoolahragajaya@seller.minecart.test', NULL, '$2y$12$OQam1OrS.eyx8NM01LPHIejCI7/x0TVl9jJK83gsAjob/YgT9m63a', NULL, '2026-06-28 15:12:51', '2026-06-28 15:12:51', '0800000000', 'Toko Olahraga Jaya, Jl. Gajah Mada No. 12, Semarang, Jawa Tengah', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Olahraga Jaya', NULL, 'user', 'active');
INSERT INTO public.users VALUES (14, 'ACE Hardware', 'acehardware@seller.minecart.test', NULL, '$2y$12$ynYIMmaAZ8b9v50DdUbqzuNVP9LLnaNpEm7qLtMZr6iB1OfaH273a', NULL, '2026-06-28 15:12:52', '2026-06-28 15:12:52', '0800000000', 'ACE Hardware, Jl. Sunset Road, Kuta, Bali', 'Kota', '00000', '1990-01-01', 'male', true, 'ACE Hardware', NULL, 'user', 'active');
INSERT INTO public.users VALUES (15, 'Jl. Trunojoyo No. 4', 'jl.trunojoyono.4@seller.minecart.test', NULL, '$2y$12$l2NlwJSkvh6HeIYGTCuadO9bPbEw8BzcUBvdMJBbLAVIXeOT/k/EG', NULL, '2026-06-28 15:12:52', '2026-06-28 15:12:52', '0800000000', 'Jl. Trunojoyo No. 4, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Jl. Trunojoyo No. 4', NULL, 'user', 'active');
INSERT INTO public.users VALUES (16, 'Toko Elektronik Sinar Jaya', 'tokoelektroniksinarjaya@seller.minecart.test', NULL, '$2y$12$Jp1EjTqU1qnEErVzP5Qn5uKjtiC4mavXx2jwRC2D1IxrqBsfZOaFC', NULL, '2026-06-28 15:12:53', '2026-06-28 15:12:53', '0800000000', 'Toko Elektronik Sinar Jaya, Jl. Ahmad Yani No. 150, Medan, Sumatera Utara', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Elektronik Sinar Jaya', NULL, 'user', 'active');
INSERT INTO public.users VALUES (17, 'Periplus', 'periplus@seller.minecart.test', NULL, '$2y$12$18jw.WDRzee2LivIM7jzF.fAWcvzsLpnaPWn4uak2LooP0Zqfi6fG', NULL, '2026-06-28 15:12:53', '2026-06-28 15:12:53', '0800000000', 'Periplus, Pondok Indah Mall 2, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Periplus', NULL, 'user', 'active');
INSERT INTO public.users VALUES (18, 'Optik Melawai', 'optikmelawai@seller.minecart.test', NULL, '$2y$12$XLAuL58zVS9jMDQgrkn6.OxsAvUqJN19GhTc.9B6WMjOjVkOxUGXa', NULL, '2026-06-28 15:12:53', '2026-06-28 15:12:53', '0800000000', 'Optik Melawai, Grand Indonesia, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Optik Melawai', NULL, 'user', 'active');
INSERT INTO public.users VALUES (19, 'Sephora', 'sephora@seller.minecart.test', NULL, '$2y$12$Z0WVohL6Hm0Vu184FkKz/eP2CzLb33kdQQbUa3SFiyP0xq/Dfqsgm', NULL, '2026-06-28 15:12:54', '2026-06-28 15:12:54', '0800000000', 'Sephora, Kota Kasablanka, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Sephora', NULL, 'user', 'active');
INSERT INTO public.users VALUES (20, 'Planet Sports', 'planetsports@seller.minecart.test', NULL, '$2y$12$AH0M/aGEHIiThKpA.xEasOjJg.E0h0hgMApvCjAtLgeC0/qpHETfC', NULL, '2026-06-28 15:12:54', '2026-06-28 15:12:54', '0800000000', 'Planet Sports, Senayan City, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Planet Sports', NULL, 'user', 'active');
INSERT INTO public.users VALUES (21, 'Informa', 'informa@seller.minecart.test', NULL, '$2y$12$Mxx/RU8S9Mmlo7S.r1Y89elaU0zH1eCUPu.wvQg7v4yUX0RdQEEzy', NULL, '2026-06-28 15:12:55', '2026-06-28 15:12:55', '0800000000', 'Informa, Living World Alam Sutera, Tangerang Selatan, Banten', 'Kota', '00000', '1990-01-01', 'male', true, 'Informa', NULL, 'user', 'active');
INSERT INTO public.users VALUES (22, 'Pusat Grosir Tanah Abang', 'pusatgrosirtanahabang@seller.minecart.test', NULL, '$2y$12$U6rwdjCphD8eqhtoetd9HOmEjCcSoL5wloIOppJyAIwtJgAWGpKtO', NULL, '2026-06-28 15:12:55', '2026-06-28 15:12:55', '0800000000', 'Pusat Grosir Tanah Abang, Blok A, Lantai 5, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Pusat Grosir Tanah Abang', NULL, 'user', 'active');
INSERT INTO public.users VALUES (23, 'Roxy Mas Square', 'roxymassquare@seller.minecart.test', NULL, '$2y$12$ogFLCGc4hA8TutzZ/PTV..QKHEbdvwNbMpPKMGk3E1nDK3lUmJORu', NULL, '2026-06-28 15:12:55', '2026-06-28 15:12:55', '0800000000', 'Roxy Mas Square, Jl. KH Hasyim Ashari, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Roxy Mas Square', NULL, 'user', 'active');
INSERT INTO public.users VALUES (24, 'Penerbit Erlangga', 'penerbiterlangga@seller.minecart.test', NULL, '$2y$12$OgR6o2IsgzbRn/ZoKklmv.YQkQMVIJ6yHTXKAAOfKIe23JTEyqIam', NULL, '2026-06-28 15:12:56', '2026-06-28 15:12:56', '0800000000', 'Penerbit Erlangga, Jl. Baping Raya No. 100, Jakarta Timur, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Penerbit Erlangga', NULL, 'user', 'active');
INSERT INTO public.users VALUES (25, 'Pengrajin Kulit Manding', 'pengrajinkulitmanding@seller.minecart.test', NULL, '$2y$12$pK1D5vf.L8fUm3/OCaEoiO2ilSr9ymW./nN8ZfkSKAYbs1tvdgRN.', NULL, '2026-06-28 15:12:56', '2026-06-28 15:12:56', '0800000000', 'Pengrajin Kulit Manding, Jl. DR. Wahidin Sudiro Husodo, Bantul, DIY', 'Kota', '00000', '1990-01-01', 'male', true, 'Pengrajin Kulit Manding', NULL, 'user', 'active');
INSERT INTO public.users VALUES (26, 'Sociolla', 'sociolla@seller.minecart.test', NULL, '$2y$12$rcSCelWMYyhvHZd3GTzQA.dFQaD9wkrZAsAHM8re.fJhDtN6D1e..', NULL, '2026-06-28 15:12:57', '2026-06-28 15:12:57', '0800000000', 'Sociolla, Mall Kelapa Gading, Jakarta Utara, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Sociolla', NULL, 'user', 'active');
INSERT INTO public.users VALUES (27, 'Decathlon', 'decathlon@seller.minecart.test', NULL, '$2y$12$/n7upQKzso9ohWXgawQAoetCMuDHj4FQjKZaTeEDoyNIO0BF80jP6', NULL, '2026-06-28 15:12:57', '2026-06-28 15:12:57', '0800000000', 'Decathlon, Mall Taman Anggrek, Jakarta Barat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Decathlon', NULL, 'user', 'active');
INSERT INTO public.users VALUES (83, 'Celebrity Fitness', 'celebrityfitness@seller.minecart.test', NULL, '$2y$12$SAfdoicivGCSkC/2XOuxBeHrfNEVYR3fKQ1oKT6yGNqQJH8zSoOSm', NULL, '2026-06-28 15:13:19', '2026-06-28 15:13:19', '0800000000', 'Celebrity Fitness, FX Sudirman, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Celebrity Fitness', NULL, 'user', 'active');
INSERT INTO public.users VALUES (28, 'Hartono Elektronika', 'hartonoelektronika@seller.minecart.test', NULL, '$2y$12$snX4fFJ3ipCQ27oRNU/.sexG6x2cpUXM1M8enOz2u09W6ZO19MIlW', NULL, '2026-06-28 15:12:58', '2026-06-28 15:12:58', '0800000000', 'Hartono Elektronika, Jl. Dr. Ir. H. Soekarno, Surabaya, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'Hartono Elektronika', NULL, 'user', 'active');
INSERT INTO public.users VALUES (29, 'Boutique The Label', 'boutiquethelabel@seller.minecart.test', NULL, '$2y$12$qmb/2QQ3eFgqkDSwUWUeeu2Iwn2fDNt4hDrxkjA.KqJ6ekG7iCR4m', NULL, '2026-06-28 15:12:58', '2026-06-28 15:12:58', '0800000000', 'Boutique The Label, Jl. Kayu Aya, Seminyak, Bali', 'Kota', '00000', '1990-01-01', 'male', true, 'Boutique The Label', NULL, 'user', 'active');
INSERT INTO public.users VALUES (30, 'Bandung Electronic Center (BEC', 'bandungelectroniccenter(bec@seller.minecart.test', NULL, '$2y$12$W8fXwZuIeD1PA0PdWEmAH.2E/x5sdCPR860N1s.CqnHXx3zZKfK4e', NULL, '2026-06-28 15:12:59', '2026-06-28 15:12:59', '0800000000', 'Bandung Electronic Center (BEC), Lantai 1, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Bandung Electronic Center (BEC', NULL, 'user', 'active');
INSERT INTO public.users VALUES (31, 'Gudang Buku', 'gudangbuku@seller.minecart.test', NULL, '$2y$12$afZxOzE5iHTsDbvYJQt5SeZEz8K3GEbAa1kxh6t.TbzL1e.Q4d0CG', NULL, '2026-06-28 15:12:59', '2026-06-28 15:12:59', '0800000000', 'Gudang Buku, Jl. Palasari No. 8, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Gudang Buku', NULL, 'user', 'active');
INSERT INTO public.users VALUES (32, 'ITC Mangga Dua', 'itcmanggadua@seller.minecart.test', NULL, '$2y$12$E4kWMvB0C0CYzXuy4wQq7eVvVFS/vbyMf4GsmSpocKfgaqbM6mh/C', NULL, '2026-06-28 15:12:59', '2026-06-28 15:12:59', '0800000000', 'ITC Mangga Dua, Lantai 4, Blok D, Jakarta Utara, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'ITC Mangga Dua', NULL, 'user', 'active');
INSERT INTO public.users VALUES (33, 'Guardian', 'guardian@seller.minecart.test', NULL, '$2y$12$JwgLCg4VSgAS5x1znm8E3.t4yn.9i3LX84oavVZg.OKjLUAJBBWLK', NULL, '2026-06-28 15:13:00', '2026-06-28 15:13:00', '0800000000', 'Guardian, Paris Van Java Mall, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Guardian', NULL, 'user', 'active');
INSERT INTO public.users VALUES (34, 'Pusat Kebugaran', 'pusatkebugaran@seller.minecart.test', NULL, '$2y$12$z.MP4EQGSc6FZArn8tP16eBcroO1iA9xo4vTy5EQBzIaNgEgrRxl2', NULL, '2026-06-28 15:13:00', '2026-06-28 15:13:00', '0800000000', 'Pusat Kebugaran, Jl. Pemuda No. 72, Rawamangun, Jakarta Timur, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Pusat Kebugaran', NULL, 'user', 'active');
INSERT INTO public.users VALUES (35, 'IKEA Kota Baru Parahyangan', 'ikeakotabaruparahyangan@seller.minecart.test', NULL, '$2y$12$MJ7hiYofpt1TMMXSlSFRfOSX1b0hXeSMboSkWcsBLhsz89uqJ8tGO', NULL, '2026-06-28 15:13:00', '2026-06-28 15:13:00', '0800000000', 'IKEA Kota Baru Parahyangan, Padalarang, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'IKEA Kota Baru Parahyangan', NULL, 'user', 'active');
INSERT INTO public.users VALUES (36, 'Toko Perlengkapan Outdoor', 'tokoperlengkapanoutdoor@seller.minecart.test', NULL, '$2y$12$ielMUJ0wJUhYFnOvlMY6OezmLEH4GfV0iKTFqr5ow5UDuaKjpEmhi', NULL, '2026-06-28 15:13:01', '2026-06-28 15:13:01', '0800000000', 'Toko Perlengkapan Outdoor, Jl. Veteran No. 33, Malang, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Perlengkapan Outdoor', NULL, 'user', 'active');
INSERT INTO public.users VALUES (37, 'Jaya Komputer', 'jayakomputer@seller.minecart.test', NULL, '$2y$12$h6b6U1/ndRPDhcU4WVVdJ.DUPdrRezWXv8ICItsUkgAu4sv0X9j1e', NULL, '2026-06-28 15:13:01', '2026-06-28 15:13:01', '0800000000', 'Jaya Komputer, Poins Square, Lt. 2, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Jaya Komputer', NULL, 'user', 'active');
INSERT INTO public.users VALUES (38, 'Gramedia Matraman', 'gramediamatraman@seller.minecart.test', NULL, '$2y$12$Yj4ywiS9rdBfypr230S6IeLpKdce7eChLlWM9P8pmHqUUqL1hsQKK', NULL, '2026-06-28 15:13:02', '2026-06-28 15:13:02', '0800000000', 'Gramedia Matraman, Jl. Matraman Raya, Jakarta Timur, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Gramedia Matraman', NULL, 'user', 'active');
INSERT INTO public.users VALUES (39, 'SOGO Dept. Store', 'sogodept.store@seller.minecart.test', NULL, '$2y$12$6pxUv5MMGJhYThtgpzkI9Oh3VHxagBmpsCyL.fVejN745yupZYJza', NULL, '2026-06-28 15:13:02', '2026-06-28 15:13:02', '0800000000', 'SOGO Dept. Store, Pakuwon Mall, Surabaya, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'SOGO Dept. Store', NULL, 'user', 'active');
INSERT INTO public.users VALUES (40, 'Kay Collection', 'kaycollection@seller.minecart.test', NULL, '$2y$12$tnNOkB9jVJA8OqtQfTNK9uKNyJ9FYDrrsBaqGrVU/EG80/KB/UcuC', NULL, '2026-06-28 15:13:03', '2026-06-28 15:13:03', '0800000000', 'Kay Collection, Central Park Mall, Jakarta Barat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Kay Collection', NULL, 'user', 'active');
INSERT INTO public.users VALUES (41, 'Sports Station', 'sportsstation@seller.minecart.test', NULL, '$2y$12$ENu3Bg1EA9pIN7BihSt2R.0A4g3MNhR3OzrXm8EXG5o0kHRBZ2kr.', NULL, '2026-06-28 15:13:03', '2026-06-28 15:13:03', '0800000000', 'Sports Station, Summarecon Mall Serpong, Tangerang, Banten', 'Kota', '00000', '1990-01-01', 'male', true, 'Sports Station', NULL, 'user', 'active');
INSERT INTO public.users VALUES (42, 'Electronic City', 'electroniccity@seller.minecart.test', NULL, '$2y$12$Hl2U/XHiFiCEv08ewAdpEO6ZgR9YKF3t3S9D9Ehwr39z.shipetKi', NULL, '2026-06-28 15:13:03', '2026-06-28 15:13:03', '0800000000', 'Electronic City, SCBD, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Electronic City', NULL, 'user', 'active');
INSERT INTO public.users VALUES (43, 'Metro Dept. Store', 'metrodept.store@seller.minecart.test', NULL, '$2y$12$ajOQma8qvwSH.QPJtrNxf.63WztSpUTi3V/uMsnCNId95mX4fktI.', NULL, '2026-06-28 15:13:04', '2026-06-28 15:13:04', '0800000000', 'Metro Dept. Store, Trans Studio Mall, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Metro Dept. Store', NULL, 'user', 'active');
INSERT INTO public.users VALUES (44, 'Gudang Gadget', 'gudanggadget@seller.minecart.test', NULL, '$2y$12$3TgTe86BEqMeyTxWzEkFdefqlOqJ9wmAHH70PRMClChOM98x50Qsq', NULL, '2026-06-28 15:13:04', '2026-06-28 15:13:04', '0800000000', 'Gudang Gadget, Jl. Kaliurang KM 5, Sleman, DIY', 'Kota', '00000', '1990-01-01', 'male', true, 'Gudang Gadget', NULL, 'user', 'active');
INSERT INTO public.users VALUES (45, 'Kios Buku', 'kiosbuku@seller.minecart.test', NULL, '$2y$12$bh6llBShzDl6P.WvobEaLe4HxsqzEjLvCSYv/Q/DitBJ3j9/35Rz.', NULL, '2026-06-28 15:13:05', '2026-06-28 15:13:05', '0800000000', 'Kios Buku, Blok M Square, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Kios Buku', NULL, 'user', 'active');
INSERT INTO public.users VALUES (46, 'Pasar Baru Trade Center', 'pasarbarutradecenter@seller.minecart.test', NULL, '$2y$12$FeNcT3KWd.pp84Sqmum5kOyPPBot0woqoRyLiuB2aKPI3VFDH0dhS', NULL, '2026-06-28 15:13:05', '2026-06-28 15:13:05', '0800000000', 'Pasar Baru Trade Center, Lantai 2, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Pasar Baru Trade Center', NULL, 'user', 'active');
INSERT INTO public.users VALUES (47, 'C&F Perfumery', 'c&fperfumery@seller.minecart.test', NULL, '$2y$12$NWE1Ltx7ta3aylmSUuEmV.E7rIus/ZqaID6Xct3vpMM41/XPaOu6S', NULL, '2026-06-28 15:13:05', '2026-06-28 15:13:05', '0800000000', 'C&F Perfumery, 23 Paskal Shopping Center, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'C&F Perfumery', NULL, 'user', 'active');
INSERT INTO public.users VALUES (48, 'GOR Saparua', 'gorsaparua@seller.minecart.test', NULL, '$2y$12$dvc7iFYYkcqNenZyiMCZ7On7FDktmcUnAmVSkxsK9b7kHcKP7kLeq', NULL, '2026-06-28 15:13:06', '2026-06-28 15:13:06', '0800000000', 'GOR Saparua, Jl. Saparua No. 2, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'GOR Saparua', NULL, 'user', 'active');
INSERT INTO public.users VALUES (49, 'Miniso', 'miniso@seller.minecart.test', NULL, '$2y$12$znnYu5DT66uV55b8z6e4IOhmQwmH1sTBJmkpZngJuesDhZ.JTx2je', NULL, '2026-06-28 15:13:06', '2026-06-28 15:13:06', '0800000000', 'Miniso, Jl. Jend. Sudirman No. 45, Yogyakarta, DIY', 'Kota', '00000', '1990-01-01', 'male', true, 'Miniso', NULL, 'user', 'active');
INSERT INTO public.users VALUES (50, 'Distro Union', 'distrounion@seller.minecart.test', NULL, '$2y$12$rpbdtWiCNFALLkZm8hiJ3OkybKb4AwCRP0oH8TUOxHokP68egYmCi', NULL, '2026-06-28 15:13:07', '2026-06-28 15:13:07', '0800000000', 'Distro Union, Jl. Sultan Agung No. 12, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Distro Union', NULL, 'user', 'active');
INSERT INTO public.users VALUES (51, 'Glodok City', 'glodokcity@seller.minecart.test', NULL, '$2y$12$dp6dweMTN5l4FqRaGJ07wuHd5vBAOANX4MhS8JWUvcI4IA9.f88.W', NULL, '2026-06-28 15:13:07', '2026-06-28 15:13:07', '0800000000', 'Glodok City, Lantai 3, Jl. Gajah Mada, Jakarta Barat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Glodok City', NULL, 'user', 'active');
INSERT INTO public.users VALUES (52, 'Kampung Buku', 'kampungbuku@seller.minecart.test', NULL, '$2y$12$RXo55Un8aH1JUfSZgCGwpO24vn7FNugoMKxSYx85sEFJeyd1qU/nO', NULL, '2026-06-28 15:13:08', '2026-06-28 15:13:08', '0800000000', 'Kampung Buku, Jl. Sumbing No. 3, Malang, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'Kampung Buku', NULL, 'user', 'active');
INSERT INTO public.users VALUES (53, 'Alun Alun Indonesia', 'alunalunindonesia@seller.minecart.test', NULL, '$2y$12$LMSp72AfkgGqpgQy45z7f.Bmt8yXtpiUUpi0.ADHZs57WbFNh6fFO', NULL, '2026-06-28 15:13:08', '2026-06-28 15:13:08', '0800000000', 'Alun Alun Indonesia, Grand Indonesia, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Alun Alun Indonesia', NULL, 'user', 'active');
INSERT INTO public.users VALUES (54, 'Klinik Kecantikan Athena', 'klinikkecantikanathena@seller.minecart.test', NULL, '$2y$12$qdW4p31gufmpFke4/vx8Hu.1npcznkh/yQ7YybsXWS63NCO.0XkTK', NULL, '2026-06-28 15:13:08', '2026-06-28 15:13:08', '0800000000', 'Klinik Kecantikan Athena, Jl. Sultan Iskandar Muda, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Klinik Kecantikan Athena', NULL, 'user', 'active');
INSERT INTO public.users VALUES (55, 'Toko Olahraga Champion', 'tokoolahragachampion@seller.minecart.test', NULL, '$2y$12$sn45xyYEAeONkwbMvXoCeeJ539yKce05XFo8rRXedCIWCHHl3NAQe', NULL, '2026-06-28 15:13:09', '2026-06-28 15:13:09', '0800000000', 'Toko Olahraga Champion, Jl. Pajajaran No. 88, Bogor, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Olahraga Champion', NULL, 'user', 'active');
INSERT INTO public.users VALUES (56, 'Best Denki', 'bestdenki@seller.minecart.test', NULL, '$2y$12$u0JBnjYnkrgdgoTtokt.tOMKtX.PUXkV94UIecAzRL.H/1QgchBeK', NULL, '2026-06-28 15:13:09', '2026-06-28 15:13:09', '0800000000', 'Best Denki, Central Park Mall, Jakarta Barat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Best Denki', NULL, 'user', 'active');
INSERT INTO public.users VALUES (57, 'Butik Gaun Pesta', 'butikgaunpesta@seller.minecart.test', NULL, '$2y$12$ghUvyie3.TsKwnKK9Z6mhOgm5ZLr/GjamD2IEpZ7Gm4fEN8tioMF2', NULL, '2026-06-28 15:13:09', '2026-06-28 15:13:09', '0800000000', 'Butik Gaun Pesta, Jl. Gunawarman No. 30, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Butik Gaun Pesta', NULL, 'user', 'active');
INSERT INTO public.users VALUES (58, 'Erafone', 'erafone@seller.minecart.test', NULL, '$2y$12$HXSroqkhwg2TeEjN0vV4EeR/T4jbhm/SxbxiSWmLHbKOdAPceAT5e', NULL, '2026-06-28 15:13:10', '2026-06-28 15:13:10', '0800000000', 'Erafone, Jl. Teuku Umar No. 120, Denpasar, Bali', 'Kota', '00000', '1990-01-01', 'male', true, 'Erafone', NULL, 'user', 'active');
INSERT INTO public.users VALUES (59, 'Penerbit Mizan', 'penerbitmizan@seller.minecart.test', NULL, '$2y$12$6dZca9T97pXDxhrH5eMfoOZA5AlK6ahKDB6lpdFkSFzY3Lf.3C.7u', NULL, '2026-06-28 15:13:10', '2026-06-28 15:13:10', '0800000000', 'Penerbit Mizan, Jl. Cinambo No. 135, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Penerbit Mizan', NULL, 'user', 'active');
INSERT INTO public.users VALUES (60, 'Wellcomm Shop', 'wellcommshop@seller.minecart.test', NULL, '$2y$12$K1EqQWV/kgHEHH60oT29euVKGeb13mUE0.kWjmt3c3qoI/0wuhLZe', NULL, '2026-06-28 15:13:11', '2026-06-28 15:13:11', '0800000000', 'Wellcomm Shop, Botani Square, Bogor, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Wellcomm Shop', NULL, 'user', 'active');
INSERT INTO public.users VALUES (61, 'Gudang Distribusi', 'gudangdistribusi@seller.minecart.test', NULL, '$2y$12$0XTxGuH2uTb7VJPo/FzrhedfQhnP.e204roAhjbGzptwd2RBMHr/S', NULL, '2026-06-28 15:13:11', '2026-06-28 15:13:11', '0800000000', 'Gudang Distribusi, Kawasan Industri Pulogadung, Jakarta Timur, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Gudang Distribusi', NULL, 'user', 'active');
INSERT INTO public.users VALUES (62, 'Motion Skate Shop', 'motionskateshop@seller.minecart.test', NULL, '$2y$12$FWvIxfjag0kbAnTIaT9b/eZHa2qdb6FXvKT3AaMTaD6vBdF/HcRYu', NULL, '2026-06-28 15:13:11', '2026-06-28 15:13:11', '0800000000', 'Motion Skate Shop, Jl. Kemang Raya No. 10, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Motion Skate Shop', NULL, 'user', 'active');
INSERT INTO public.users VALUES (63, 'Otten Coffee', 'ottencoffee@seller.minecart.test', NULL, '$2y$12$hCzSdg1sgfR.PmErGPxhn.iWQyu8lxApeIuAoFFfo7R1DoZNx6hDe', NULL, '2026-06-28 15:13:12', '2026-06-28 15:13:12', '0800000000', 'Otten Coffee, Jl. Pasirkaliki No. 169, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Otten Coffee', NULL, 'user', 'active');
INSERT INTO public.users VALUES (64, 'Jeans Street', 'jeansstreet@seller.minecart.test', NULL, '$2y$12$ndB7JERgKPQ3xmspe5gY1OwbeFI7xLM69npd6h64nthdK6GEOjMpa', NULL, '2026-06-28 15:13:12', '2026-06-28 15:13:12', '0800000000', 'Jeans Street, Jl. Cihampelas No. 160, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Jeans Street', NULL, 'user', 'active');
INSERT INTO public.users VALUES (65, 'IT Galaxy', 'itgalaxy@seller.minecart.test', NULL, '$2y$12$PEb3SPHxWn3LXGJfwsfhmeuT5cUSgzwpgrc6sz.vB8/ximfBDnJkW', NULL, '2026-06-28 15:13:13', '2026-06-28 15:13:13', '0800000000', 'IT Galaxy, Ratu Plaza, Lantai 3, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'IT Galaxy', NULL, 'user', 'active');
INSERT INTO public.users VALUES (66, 'Books & Beyond', 'books&beyond@seller.minecart.test', NULL, '$2y$12$nh5UIYxzrmCqrYrlXuGL4OJNoJa8LMuy1p5V7Y5OuSE72SVmyPiAS', NULL, '2026-06-28 15:13:13', '2026-06-28 15:13:13', '0800000000', 'Books & Beyond, Lippo Mall Kemang, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Books & Beyond', NULL, 'user', 'active');
INSERT INTO public.users VALUES (67, 'Pasar Seni Sukawati', 'pasarsenisukawati@seller.minecart.test', NULL, '$2y$12$v5GoHLwkfk.wHcvUNUOuPewy4I8evUv.PkP.YownpSfHS73OWhgZ2', NULL, '2026-06-28 15:13:13', '2026-06-28 15:13:13', '0800000000', 'Pasar Seni Sukawati, Gianyar, Bali', 'Kota', '00000', '1990-01-01', 'male', true, 'Pasar Seni Sukawati', NULL, 'user', 'active');
INSERT INTO public.users VALUES (68, 'Beauty Haul', 'beautyhaul@seller.minecart.test', NULL, '$2y$12$xmhI7.e4cs4nun.By01.H.HKguIIVVH.UmaB38HJboeJISCDWLXaS', NULL, '2026-06-28 15:13:14', '2026-06-28 15:13:14', '0800000000', 'Beauty Haul, Jl. Wolter Monginsidi No. 5, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Beauty Haul', NULL, 'user', 'active');
INSERT INTO public.users VALUES (69, 'Toko Olahraga Pantai', 'tokoolahragapantai@seller.minecart.test', NULL, '$2y$12$fnRaoKEbAL6zAXK3tAyIT.myEQ9sL.u/vuYC7okLBJhxHLGlooqL6', NULL, '2026-06-28 15:13:14', '2026-06-28 15:13:14', '0800000000', 'Toko Olahraga Pantai, Jl. Legian, Kuta, Bali', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Olahraga Pantai', NULL, 'user', 'active');
INSERT INTO public.users VALUES (70, 'Pantry Magic', 'pantrymagic@seller.minecart.test', NULL, '$2y$12$l7jooFcsq96XaDvV/4aVrOg0Ua4HOt/qcQwIFoir183jXdLgFsmve', NULL, '2026-06-28 15:13:14', '2026-06-28 15:13:14', '0800000000', 'Pantry Magic, Jl. Kemang Raya No. 12, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Pantry Magic', NULL, 'user', 'active');
INSERT INTO public.users VALUES (71, 'Pusat Kerajinan Kulit', 'pusatkerajinankulit@seller.minecart.test', NULL, '$2y$12$pw6H4.FtTUI01j65CgRxUOAH2P3n/IgGKWW1dv92MLEapWluresFe', NULL, '2026-06-28 15:13:15', '2026-06-28 15:13:15', '0800000000', 'Pusat Kerajinan Kulit, Jl. A.H. Nasution, Garut, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Pusat Kerajinan Kulit', NULL, 'user', 'active');
INSERT INTO public.users VALUES (72, 'Enter Komputer', 'enterkomputer@seller.minecart.test', NULL, '$2y$12$RQQqAGjqAIfALftxngi7Xer1c0ml3dYcgmGkP5Fvi3RzuzQI2jza6', NULL, '2026-06-28 15:13:15', '2026-06-28 15:13:15', '0800000000', 'Enter Komputer, Mangga Dua Mall, Lantai 5, Jakarta Utara, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Enter Komputer', NULL, 'user', 'active');
INSERT INTO public.users VALUES (73, 'Koleksi Dapur', 'koleksidapur@seller.minecart.test', NULL, '$2y$12$49/WN.15pnOo9ghExzJIz.UQ1cbK8SZLuTfTV4qS0T/qGW0p/P/su', NULL, '2026-06-28 15:13:16', '2026-06-28 15:13:16', '0800000000', 'Koleksi Dapur, Jl. Radio Dalam Raya, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Koleksi Dapur', NULL, 'user', 'active');
INSERT INTO public.users VALUES (74, 'Eiger Adventure Store', 'eigeradventurestore@seller.minecart.test', NULL, '$2y$12$homCeXobj4YVCgbS/05zMeb.yCpDtVlXIXS/OTTTroDClsLzQ7n7C', NULL, '2026-06-28 15:13:16', '2026-06-28 15:13:16', '0800000000', 'Eiger Adventure Store, Jl. Sumatera No. 23, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Eiger Adventure Store', NULL, 'user', 'active');
INSERT INTO public.users VALUES (75, 'Toko Kosmetik Mahkota', 'tokokosmetikmahkota@seller.minecart.test', NULL, '$2y$12$qHm3BRYt2M6QPc1KsFUB9uNIsGxFnap3iQGwMQ7vSt.Eks5NHSqfO', NULL, '2026-06-28 15:13:16', '2026-06-28 15:13:16', '0800000000', 'Toko Kosmetik Mahkota, Pasar Baru, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Kosmetik Mahkota', NULL, 'user', 'active');
INSERT INTO public.users VALUES (76, 'Arena Store', 'arenastore@seller.minecart.test', NULL, '$2y$12$Xlx7b9VR4e0rZqZ8b8U/quWM2Di/yA0qXp7n31jVLb86FDYWPDLZO', NULL, '2026-06-28 15:13:17', '2026-06-28 15:13:17', '0800000000', 'Arena Store, Pondok Indah Water Park, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Arena Store', NULL, 'user', 'active');
INSERT INTO public.users VALUES (77, 'Toko Sinar Lestari', 'tokosinarlestari@seller.minecart.test', NULL, '$2y$12$tAe7a53O9ydbWiOa49qLneBRvblRsyOb1R5s8.CSDaXLsn6EnmmGS', NULL, '2026-06-28 15:13:17', '2026-06-28 15:13:17', '0800000000', 'Toko Sinar Lestari, Jl. Glodok, Jakarta Barat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Sinar Lestari', NULL, 'user', 'active');
INSERT INTO public.users VALUES (78, 'Uniqlo', 'uniqlo@seller.minecart.test', NULL, '$2y$12$zueLNvbEvkVmPHRPJJ4X3OX7fKY6wxMwIWAFmtwAJOnl47g80qLDW', NULL, '2026-06-28 15:13:18', '2026-06-28 15:13:18', '0800000000', 'Uniqlo, Paris Van Java Mall, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Uniqlo', NULL, 'user', 'active');
INSERT INTO public.users VALUES (79, 'Dunia Komputer', 'duniakomputer@seller.minecart.test', NULL, '$2y$12$TEd1PZ/kn1G4IApIdPkr9e.rI9X4umAhIlYsQGz5KVYGhYshVl406', NULL, '2026-06-28 15:13:18', '2026-06-28 15:13:18', '0800000000', 'Dunia Komputer, Jl. Diponegoro No. 132, Surabaya, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'Dunia Komputer', NULL, 'user', 'active');
INSERT INTO public.users VALUES (80, 'Gramedia', 'gramedia@seller.minecart.test', NULL, '$2y$12$MalFfLsAzUtU9Jc7FOh3j.JLCrrO2hOLoU8wzvCuoMc..b6L5Ecbm', NULL, '2026-06-28 15:13:18', '2026-06-28 15:13:18', '0800000000', 'Gramedia, Jl. Pandanaran No. 42, Semarang, Jawa Tengah', 'Kota', '00000', '1990-01-01', 'male', true, 'Gramedia', NULL, 'user', 'active');
INSERT INTO public.users VALUES (81, 'Stradivarius', 'stradivarius@seller.minecart.test', NULL, '$2y$12$BLVOfyawAQmK2pCPmQCLHOZyl2wxH8fupi0TVgbuJbVKRdwOlqGE2', NULL, '2026-06-28 15:13:19', '2026-06-28 15:13:19', '0800000000', 'Stradivarius, Beachwalk Shopping Center, Kuta, Bali', 'Kota', '00000', '1990-01-01', 'male', true, 'Stradivarius', NULL, 'user', 'active');
INSERT INTO public.users VALUES (82, 'Toko Perlengkapan Salon', 'tokoperlengkapansalon@seller.minecart.test', NULL, '$2y$12$9xZ1y6iZBvCF5msuFRqdH.Oq/6l0DV0XNDKTBYWs5n3gUK.UK5XJO', NULL, '2026-06-28 15:13:19', '2026-06-28 15:13:19', '0800000000', 'Toko Perlengkapan Salon, Pasar Pagi Mangga Dua, Jakarta Utara, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Perlengkapan Salon', NULL, 'user', 'active');
INSERT INTO public.users VALUES (84, 'Pengrajin Kayu Jepara', 'pengrajinkayujepara@seller.minecart.test', NULL, '$2y$12$uqrYoJnIkSYqeHsd5R1wqewrDFdu564./ZFAQcXrKczERT9eVdqPi', NULL, '2026-06-28 15:13:20', '2026-06-28 15:13:20', '0800000000', 'Pengrajin Kayu Jepara, Jl. Tahunan, Jepara, Jawa Tengah', 'Kota', '00000', '1990-01-01', 'male', true, 'Pengrajin Kayu Jepara', NULL, 'user', 'active');
INSERT INTO public.users VALUES (85, 'Pusat Rajut Binong Jati', 'pusatrajutbinongjati@seller.minecart.test', NULL, '$2y$12$rZG/1FNmOUtbMboFyhQjteIWetVDVNHpd0lRrZItU3pGjZd9GUxKa', NULL, '2026-06-28 15:13:20', '2026-06-28 15:13:20', '0800000000', 'Pusat Rajut Binong Jati, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Pusat Rajut Binong Jati', NULL, 'user', 'active');
INSERT INTO public.users VALUES (86, 'Toko Kamera Focus Nusantara', 'tokokamerafocusnusantara@seller.minecart.test', NULL, '$2y$12$JqW.QiJb/R2NINywpTaXpO8hISNPsoJDF2H7OKmU.gmAVfhllXSzy', NULL, '2026-06-28 15:13:21', '2026-06-28 15:13:21', '0800000000', 'Toko Kamera Focus Nusantara, Jl. Panglima Polim, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Kamera Focus Nusantara', NULL, 'user', 'active');
INSERT INTO public.users VALUES (87, 'Kinokuniya', 'kinokuniya@seller.minecart.test', NULL, '$2y$12$sIEYTJMEItSVfyyiKFIg7.x8KHQLnxIOc.eGBV2cSh1PoF5XD878.', NULL, '2026-06-28 15:13:21', '2026-06-28 15:13:21', '0800000000', 'Kinokuniya, Plaza Senayan, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Kinokuniya', NULL, 'user', 'active');
INSERT INTO public.users VALUES (88, 'Pusat Aksesoris Asemka', 'pusataksesorisasemka@seller.minecart.test', NULL, '$2y$12$Dva5qwZADRT8K9srm97toeBCaL61XpdWeXqvkXgQxO6y7/QpxUBYm', NULL, '2026-06-28 15:13:21', '2026-06-28 15:13:21', '0800000000', 'Pusat Aksesoris Asemka, Jakarta Barat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Pusat Aksesoris Asemka', NULL, 'user', 'active');
INSERT INTO public.users VALUES (89, 'Century Healthcare', 'centuryhealthcare@seller.minecart.test', NULL, '$2y$12$SxettyoD6IDSlDmh8bli.uxE/8UsJJKixceJxBPOHkJLcrr.mDfcO', NULL, '2026-06-28 15:13:22', '2026-06-28 15:13:22', '0800000000', 'Century Healthcare, Jl. Raya Kuta No. 88, Bali', 'Kota', '00000', '1990-01-01', 'male', true, 'Century Healthcare', NULL, 'user', 'active');
INSERT INTO public.users VALUES (90, 'Athlete''s Foot', 'athlete''sfoot@seller.minecart.test', NULL, '$2y$12$HtYIjIzGSmb/Z6iDNGUQCOuCo45TD2dyV3UsmX.pwBYFrwvH1nTnm', NULL, '2026-06-28 15:13:22', '2026-06-28 15:13:22', '0800000000', 'Athlete''s Foot, Galaxy Mall, Surabaya, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'Athlete''s Foot', NULL, 'user', 'active');
INSERT INTO public.users VALUES (91, 'Toko Perabot Laris', 'tokoperabotlaris@seller.minecart.test', NULL, '$2y$12$le7yPoLMOfYMHvzxcFwpO.jIVFlho811hjPF6h9guIeuZ9OlX0SP6', NULL, '2026-06-28 15:13:23', '2026-06-28 15:13:23', '0800000000', 'Toko Perabot Laris, Jl. Urip Sumoharjo, Makassar, Sulawesi Selatan', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Perabot Laris', NULL, 'user', 'active');
INSERT INTO public.users VALUES (92, 'Polo Ralph Lauren', 'poloralphlauren@seller.minecart.test', NULL, '$2y$12$OFO.re91suyGwsFkPoWYVuu7.fnbwFZKjvnqDo2jPTqDFxa7spDj6', NULL, '2026-06-28 15:13:23', '2026-06-28 15:13:23', '0800000000', 'Polo Ralph Lauren, Plaza Indonesia, Jakarta Pusat, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Polo Ralph Lauren', NULL, 'user', 'active');
INSERT INTO public.users VALUES (93, 'Quantum Computer', 'quantumcomputer@seller.minecart.test', NULL, '$2y$12$Y3sBS9MZmaR8z.zF10abyO3KpZ.dazx1YRf6xIlfePXdh6rZdQjcq', NULL, '2026-06-28 15:13:23', '2026-06-28 15:13:23', '0800000000', 'Quantum Computer, Jogjatronik Mall, Lantai 2, Yogyakarta, DIY', 'Kota', '00000', '1990-01-01', 'male', true, 'Quantum Computer', NULL, 'user', 'active');
INSERT INTO public.users VALUES (94, 'Typo', 'typo@seller.minecart.test', NULL, '$2y$12$dJG/Q11Te/PEuYKrK1nLauWXyaRHqbJ1fxvDR0xnlHtvseWnerPfa', NULL, '2026-06-28 15:13:24', '2026-06-28 15:13:24', '0800000000', 'Typo, Kota Kasablanka, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'Typo', NULL, 'user', 'active');
INSERT INTO public.users VALUES (95, 'Workshop Kulit', 'workshopkulit@seller.minecart.test', NULL, '$2y$12$RGzVR82lR5Lf.Fm67BtxQ..Vt6RHxclBAJfkwJbsMvxNAaRqPJOOC', NULL, '2026-06-28 15:13:24', '2026-06-28 15:13:24', '0800000000', 'Workshop Kulit, Jl. Malioboro No. 99, Yogyakarta, DIY', 'Kota', '00000', '1990-01-01', 'male', true, 'Workshop Kulit', NULL, 'user', 'active');
INSERT INTO public.users VALUES (96, 'The Body Shop', 'thebodyshop@seller.minecart.test', NULL, '$2y$12$wFNnCGuh/WqeyQotpS5mau2ZU1V7d/hfWgfnOjOQwfhONpVFRzSYq', NULL, '2026-06-28 15:13:24', '2026-06-28 15:13:24', '0800000000', 'The Body Shop, Ambarrukmo Plaza, Sleman, DIY', 'Kota', '00000', '1990-01-01', 'male', true, 'The Body Shop', NULL, 'user', 'active');
INSERT INTO public.users VALUES (97, 'Adidas Store', 'adidasstore@seller.minecart.test', NULL, '$2y$12$K.VWfNMV4oUevipq3qOPQezOVNx5J8DUHkv.1zk599WjYzj4y3Oti', NULL, '2026-06-28 15:13:25', '2026-06-28 15:13:25', '0800000000', 'Adidas Store, 23 Paskal Shopping Center, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Adidas Store', NULL, 'user', 'active');
INSERT INTO public.users VALUES (98, 'Toko Bahan Kue', 'tokobahankue@seller.minecart.test', NULL, '$2y$12$c./Ct2vIn9qesW3LWQ5xXuTI9zmcWm7czmQ1iX/24TZfLqWuL7rTm', NULL, '2026-06-28 15:13:25', '2026-06-28 15:13:25', '0800000000', 'Toko Bahan Kue, Jl. Mayjend Sungkono No. 88, Surabaya, Jawa Timur', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Bahan Kue', NULL, 'user', 'active');
INSERT INTO public.users VALUES (99, 'Mango', 'mango@seller.minecart.test', NULL, '$2y$12$P8iv8CWcm38T6fux9C7r4uMM/kQI2aDsFS2kKt7TbOjl6Q0ICvfpa', NULL, '2026-06-28 15:13:26', '2026-06-28 15:13:26', '0800000000', 'Mango, Deli Park Mall, Medan, Sumatera Utara', 'Kota', '00000', '1990-01-01', 'male', true, 'Mango', NULL, 'user', 'active');
INSERT INTO public.users VALUES (100, 'KliknKlik', 'kliknklik@seller.minecart.test', NULL, '$2y$12$nE/A76Cij9t3WQ29VnW63.9S2wqRlcms0xoaz0ASpaV/S6GVFcsfO', NULL, '2026-06-28 15:13:26', '2026-06-28 15:13:26', '0800000000', 'KliknKlik, Ratu Plaza, Lantai 1, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'KliknKlik', NULL, 'user', 'active');
INSERT INTO public.users VALUES (101, 'Toko Buku Eureka', 'tokobukueureka@seller.minecart.test', NULL, '$2y$12$okGzAGvsXPLDOMf44TQy0e2KXzv.OTkBn9gdYlWMUfkADIQhKOBM.', NULL, '2026-06-28 15:13:26', '2026-06-28 15:13:26', '0800000000', 'Toko Buku Eureka, Jl. C. Simanjuntak No. 10, Yogyakarta, DIY', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Buku Eureka', NULL, 'user', 'active');
INSERT INTO public.users VALUES (102, 'M Bloc Market', 'mblocmarket@seller.minecart.test', NULL, '$2y$12$JsFqamrC89wY5w4Gi14acu6wEhLdU6eKORiRVIHEF8.C9HRaDKUBm', NULL, '2026-06-28 15:13:27', '2026-06-28 15:13:27', '0800000000', 'M Bloc Market, Jl. Sisingamangaraja, Jakarta Selatan, DKI Jakarta', 'Kota', '00000', '1990-01-01', 'male', true, 'M Bloc Market', NULL, 'user', 'active');
INSERT INTO public.users VALUES (103, 'Toko Kaca & Cermin', 'tokokaca&cermin@seller.minecart.test', NULL, '$2y$12$hEYe8SqfuXWBfQE5mAtGuudyqoJMIxHTVqpUciA0oBs8g38spYLP6', NULL, '2026-06-28 15:13:27', '2026-06-28 15:13:27', '0800000000', 'Toko Kaca & Cermin, Jl. ABC, Bandung, Jawa Barat', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Kaca & Cermin', NULL, 'user', 'active');
INSERT INTO public.users VALUES (104, 'Daiso', 'daiso@seller.minecart.test', NULL, '$2y$12$FibolQy77pr9bbK43E8.GenCR5NiahMwY7VyCB6h.PhGvzWYk7XFa', NULL, '2026-06-28 15:13:28', '2026-06-28 15:13:28', '0800000000', 'Daiso, AEON Mall BSD City, Tangerang, Banten', 'Kota', '00000', '1990-01-01', 'male', true, 'Daiso', NULL, 'user', 'active');
INSERT INTO public.users VALUES (105, 'Toko Elektronik ABC', 'tokoelektronikabc@seller.minecart.test', NULL, '$2y$12$Q6QgEIDGjReUbD8YDrSv5urM0635mzVizjPF7hy9.uRRos6Lrm1US', NULL, '2026-06-28 15:13:28', '2026-06-28 15:13:28', '0800000000', 'Toko Elektronik ABC, Jl. Pahlawan No. 99, Palembang, Sumatera Selatan', 'Kota', '00000', '1990-01-01', 'male', true, 'Toko Elektronik ABC', NULL, 'user', 'active');
INSERT INTO public.users VALUES (106, 'Pangeran Valerensco Rivaldi Hutabarat', 'pangeranvalerensco@gmail.com', NULL, '$2y$12$dlgstgIHmH7TQkiCJ3Mok.Fb8ABDGJMah9xtFbT4DgANXmtfI4Axe', 'wDP9zf0uA2L9tLMdcMYSrsluLMNaOWFMLR0KAADBeOm2YDowrDttjrbpEMHv', '2026-06-28 15:17:52', '2026-06-29 06:07:57', NULL, NULL, NULL, NULL, '2005-10-18', 'male', true, 'Syntax', '103381744166293754976', 'user', 'active');


--
-- TOC entry 5278 (class 0 OID 67645)
-- Dependencies: 259
-- Data for Name: wallet_transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5274 (class 0 OID 67606)
-- Dependencies: 255
-- Data for Name: wallets; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5268 (class 0 OID 67534)
-- Dependencies: 249
-- Data for Name: wishlists; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5276 (class 0 OID 67622)
-- Dependencies: 257
-- Data for Name: withdrawals; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 5303 (class 0 OID 0)
-- Dependencies: 232
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 6, true);


--
-- TOC entry 5304 (class 0 OID 0)
-- Dependencies: 244
-- Name: conversations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.conversations_id_seq', 1, true);


--
-- TOC entry 5305 (class 0 OID 0)
-- Dependencies: 250
-- Name: coupons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.coupons_id_seq', 2, true);


--
-- TOC entry 5306 (class 0 OID 0)
-- Dependencies: 230
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 5307 (class 0 OID 0)
-- Dependencies: 227
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- TOC entry 5308 (class 0 OID 0)
-- Dependencies: 246
-- Name: messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.messages_id_seq', 1, false);


--
-- TOC entry 5309 (class 0 OID 0)
-- Dependencies: 219
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 31, true);


--
-- TOC entry 5310 (class 0 OID 0)
-- Dependencies: 238
-- Name: order_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.order_items_id_seq', 9, true);


--
-- TOC entry 5311 (class 0 OID 0)
-- Dependencies: 236
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_id_seq', 8, true);


--
-- TOC entry 5312 (class 0 OID 0)
-- Dependencies: 240
-- Name: password_reset_otps_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.password_reset_otps_id_seq', 1, true);


--
-- TOC entry 5313 (class 0 OID 0)
-- Dependencies: 234
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.products_id_seq', 107, true);


--
-- TOC entry 5314 (class 0 OID 0)
-- Dependencies: 242
-- Name: reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reviews_id_seq', 1, true);


--
-- TOC entry 5315 (class 0 OID 0)
-- Dependencies: 252
-- Name: settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.settings_id_seq', 1, false);


--
-- TOC entry 5316 (class 0 OID 0)
-- Dependencies: 221
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 106, true);


--
-- TOC entry 5317 (class 0 OID 0)
-- Dependencies: 258
-- Name: wallet_transactions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.wallet_transactions_id_seq', 1, false);


--
-- TOC entry 5318 (class 0 OID 0)
-- Dependencies: 254
-- Name: wallets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.wallets_id_seq', 1, false);


--
-- TOC entry 5319 (class 0 OID 0)
-- Dependencies: 248
-- Name: wishlists_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.wishlists_id_seq', 1, false);


--
-- TOC entry 5320 (class 0 OID 0)
-- Dependencies: 256
-- Name: withdrawals_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.withdrawals_id_seq', 1, false);


--
-- TOC entry 5020 (class 2606 OID 67275)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 5017 (class 2606 OID 67264)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 5031 (class 2606 OID 67335)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- TOC entry 5033 (class 2606 OID 67337)
-- Name: categories categories_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_slug_unique UNIQUE (slug);


--
-- TOC entry 5050 (class 2606 OID 67507)
-- Name: conversations conversations_buyer_id_seller_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.conversations
    ADD CONSTRAINT conversations_buyer_id_seller_id_unique UNIQUE (buyer_id, seller_id);


--
-- TOC entry 5052 (class 2606 OID 67495)
-- Name: conversations conversations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.conversations
    ADD CONSTRAINT conversations_pkey PRIMARY KEY (id);


--
-- TOC entry 5060 (class 2606 OID 67576)
-- Name: coupons coupons_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coupons
    ADD CONSTRAINT coupons_code_unique UNIQUE (code);


--
-- TOC entry 5062 (class 2606 OID 67574)
-- Name: coupons coupons_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.coupons
    ADD CONSTRAINT coupons_pkey PRIMARY KEY (id);


--
-- TOC entry 5027 (class 2606 OID 67323)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 5029 (class 2606 OID 67325)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 5025 (class 2606 OID 67306)
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- TOC entry 5022 (class 2606 OID 67291)
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 5054 (class 2606 OID 67522)
-- Name: messages messages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (id);


--
-- TOC entry 5004 (class 2606 OID 67218)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 5041 (class 2606 OID 67402)
-- Name: order_items order_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_pkey PRIMARY KEY (id);


--
-- TOC entry 5037 (class 2606 OID 67389)
-- Name: orders orders_order_number_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_order_number_unique UNIQUE (order_number);


--
-- TOC entry 5039 (class 2606 OID 67387)
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- TOC entry 5044 (class 2606 OID 67449)
-- Name: password_reset_otps password_reset_otps_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_otps
    ADD CONSTRAINT password_reset_otps_pkey PRIMARY KEY (id);


--
-- TOC entry 5010 (class 2606 OID 67242)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 5035 (class 2606 OID 67358)
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- TOC entry 5046 (class 2606 OID 67464)
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- TOC entry 5048 (class 2606 OID 67481)
-- Name: reviews reviews_user_id_order_item_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_user_id_order_item_id_unique UNIQUE (user_id, order_item_id);


--
-- TOC entry 5013 (class 2606 OID 67252)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 5064 (class 2606 OID 67598)
-- Name: settings settings_key_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_key_unique UNIQUE (key);


--
-- TOC entry 5066 (class 2606 OID 67596)
-- Name: settings settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.settings
    ADD CONSTRAINT settings_pkey PRIMARY KEY (id);


--
-- TOC entry 5006 (class 2606 OID 67233)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 5008 (class 2606 OID 67231)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 5072 (class 2606 OID 67658)
-- Name: wallet_transactions wallet_transactions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wallet_transactions
    ADD CONSTRAINT wallet_transactions_pkey PRIMARY KEY (id);


--
-- TOC entry 5068 (class 2606 OID 67615)
-- Name: wallets wallets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wallets
    ADD CONSTRAINT wallets_pkey PRIMARY KEY (id);


--
-- TOC entry 5056 (class 2606 OID 67542)
-- Name: wishlists wishlists_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlists
    ADD CONSTRAINT wishlists_pkey PRIMARY KEY (id);


--
-- TOC entry 5058 (class 2606 OID 67554)
-- Name: wishlists wishlists_user_id_product_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlists
    ADD CONSTRAINT wishlists_user_id_product_id_unique UNIQUE (user_id, product_id);


--
-- TOC entry 5070 (class 2606 OID 67638)
-- Name: withdrawals withdrawals_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.withdrawals
    ADD CONSTRAINT withdrawals_pkey PRIMARY KEY (id);


--
-- TOC entry 5015 (class 1259 OID 67265)
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- TOC entry 5018 (class 1259 OID 67276)
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- TOC entry 5023 (class 1259 OID 67292)
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- TOC entry 5042 (class 1259 OID 67450)
-- Name: password_reset_otps_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX password_reset_otps_email_index ON public.password_reset_otps USING btree (email);


--
-- TOC entry 5011 (class 1259 OID 67254)
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- TOC entry 5014 (class 1259 OID 67253)
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- TOC entry 5082 (class 2606 OID 67496)
-- Name: conversations conversations_buyer_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.conversations
    ADD CONSTRAINT conversations_buyer_id_foreign FOREIGN KEY (buyer_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5083 (class 2606 OID 67501)
-- Name: conversations conversations_seller_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.conversations
    ADD CONSTRAINT conversations_seller_id_foreign FOREIGN KEY (seller_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5084 (class 2606 OID 67523)
-- Name: messages messages_conversation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_conversation_id_foreign FOREIGN KEY (conversation_id) REFERENCES public.conversations(id) ON DELETE CASCADE;


--
-- TOC entry 5085 (class 2606 OID 67528)
-- Name: messages messages_sender_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_sender_id_foreign FOREIGN KEY (sender_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5077 (class 2606 OID 67403)
-- Name: order_items order_items_order_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_order_id_foreign FOREIGN KEY (order_id) REFERENCES public.orders(id) ON DELETE CASCADE;


--
-- TOC entry 5078 (class 2606 OID 67408)
-- Name: order_items order_items_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE SET NULL;


--
-- TOC entry 5075 (class 2606 OID 67577)
-- Name: orders orders_coupon_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_coupon_id_foreign FOREIGN KEY (coupon_id) REFERENCES public.coupons(id) ON DELETE SET NULL;


--
-- TOC entry 5076 (class 2606 OID 67413)
-- Name: orders orders_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- TOC entry 5073 (class 2606 OID 67359)
-- Name: products products_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE SET NULL;


--
-- TOC entry 5074 (class 2606 OID 67420)
-- Name: products products_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5079 (class 2606 OID 67475)
-- Name: reviews reviews_order_item_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_order_item_id_foreign FOREIGN KEY (order_item_id) REFERENCES public.order_items(id) ON DELETE CASCADE;


--
-- TOC entry 5080 (class 2606 OID 67470)
-- Name: reviews reviews_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 5081 (class 2606 OID 67465)
-- Name: reviews reviews_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5090 (class 2606 OID 67659)
-- Name: wallet_transactions wallet_transactions_wallet_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wallet_transactions
    ADD CONSTRAINT wallet_transactions_wallet_id_foreign FOREIGN KEY (wallet_id) REFERENCES public.wallets(id) ON DELETE CASCADE;


--
-- TOC entry 5088 (class 2606 OID 67616)
-- Name: wallets wallets_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wallets
    ADD CONSTRAINT wallets_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5086 (class 2606 OID 67548)
-- Name: wishlists wishlists_product_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlists
    ADD CONSTRAINT wishlists_product_id_foreign FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 5087 (class 2606 OID 67543)
-- Name: wishlists wishlists_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlists
    ADD CONSTRAINT wishlists_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5089 (class 2606 OID 67639)
-- Name: withdrawals withdrawals_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.withdrawals
    ADD CONSTRAINT withdrawals_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


-- Completed on 2026-06-30 22:40:59

--
-- PostgreSQL database dump complete
--

\unrestrict fROByPk3bqNjTdA6ZHDt2V8V8h7lA9PhSSkaqRaqbvF3QFzw7V2NIfkbGZEQO0g


/*
 Navicat Premium Data Transfer

 Source Server         : predict.vbox
 Source Server Type    : PostgreSQL
 Source Server Version : 90405
 Source Host           : 192.168.1.37
 Source Database       : tests
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 90405
 File Encoding         : utf-8

 Date: 04/18/2016 11:36:12 AM
*/

-- ----------------------------
--  Table structure for imported_file
-- ----------------------------
DROP TABLE IF EXISTS "public"."imported_file";
CREATE TABLE "public"."imported_file" (
	"id" int4 NOT NULL,
	"name" varchar COLLATE "default"
)
WITH (OIDS=FALSE);
ALTER TABLE "public"."imported_file" OWNER TO "postgres";

-- ----------------------------
--  Records of imported_file
-- ----------------------------
BEGIN;
INSERT INTO "public"."imported_file" VALUES ('1', 'John Doe''');
COMMIT;

-- ----------------------------
--  Primary key structure for table imported_file
-- ----------------------------
ALTER TABLE "public"."imported_file" ADD PRIMARY KEY ("id") NOT DEFERRABLE INITIALLY IMMEDIATE;

/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : agendas-do-gov

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 05/10/2021 17:44:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for events
-- ----------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events`  (
  `date` date NULL DEFAULT NULL,
  `week_day` int(1) NULL DEFAULT NULL,
  `hour_start` time NULL DEFAULT NULL,
  `hour_end` time NULL DEFAULT NULL,
  `interval` int(4) NULL DEFAULT NULL,
  `title` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `place` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `schedule_id` int(11) NULL DEFAULT NULL,
  INDEX `date`(`date`) USING BTREE,
  INDEX `schedule_id`(`schedule_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of events
-- ----------------------------

-- ----------------------------
-- Table structure for schedule
-- ----------------------------
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `political_party` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `department` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `initials` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dashboard` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `start_date` date NOT NULL,
  `active` int(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of schedule
-- ----------------------------
INSERT INTO `schedule` VALUES (1, 'Jair Bolsonaro', NULL, 'Presidencia da Republica', NULL, 'https://www.gov.br/planalto/pt-br/acompanhe-o-planalto/agenda-do-presidente-da-republica/', 'https://datawrapper.dwcdn.net/v7KC3/', '2019-01-01', 1);
INSERT INTO `schedule` VALUES (2, 'Marcelo Queiroga', NULL, 'Saúde', 'MS', 'https://www.gov.br/saude/pt-br/acesso-a-informacao/agenda-de-autoridades/gabinete-do-ministro/ministro-de-estado-da-saude/ministro-da-saude/', 'https://datawrapper.dwcdn.net/v1lLP/', '2021-03-16', 1);
INSERT INTO `schedule` VALUES (3, 'Tereza Cristina', 'DEM', 'Agricultura, Pecuária e Abastecimento', 'MAPA', 'https://www.gov.br/agricultura/pt-br/acesso-a-informacao/agendas/ministro-e-staff/agenda-da-ministra/', NULL, '2019-01-01', 0);
INSERT INTO `schedule` VALUES (4, 'João Roma', 'Republicanos', 'Cidadania', 'MC', 'https://antigo.cidadania.gov.br/ministerio/agendas/ministro', NULL, '2021-02-12', 0);
INSERT INTO `schedule` VALUES (5, 'Marcos Pontes', 'PSL', 'Ciência, Tecnologia e Inovações', 'MCTI', 'https://www.gov.br/mcti/pt-br/acesso-a-informacao/agenda-de-autoridades/agenda-ministro/', NULL, '2019-01-01', 0);
INSERT INTO `schedule` VALUES (6, 'Fábio Faria', 'PSD', 'Comunicações', 'MCom', 'https://www.gov.br/mcom/pt-br/agenda-de-autoridades/gabinete-do-ministro/ministro/', NULL, '2020-06-10', 0);
INSERT INTO `schedule` VALUES (7, 'Walter Braga Netto', NULL, 'Defesa', 'MD', 'https://www.gov.br/casacivil/pt-br/acesso-a-informacao/agendas-da-casa-civil/agenda-do-ministro/', NULL, '2021-03-30', 0);
INSERT INTO `schedule` VALUES (8, 'Rogério Marinho', NULL, 'Desenvolvimento Regional', 'MDR', 'https://www.gov.br/mdr/pt-br/acesso-a-informacao/agenda-do-ministro', NULL, '2020-02-11', 0);
INSERT INTO `schedule` VALUES (9, 'Paulo Guedes', '', 'Economia', 'ME', 'http://antigo.economia.gov.br/Economia/agendas/gabinete-do-ministro/ministro-da-economia/paulo-guedes/', NULL, '2019-01-01', 0);
INSERT INTO `schedule` VALUES (10, 'Milton Ribeiro', NULL, 'Educação', 'MEC', 'http://portal.mec.gov.br/agenda-dirigentes-2015?view=autoridadesdetalhamento&data_calendario=', NULL, '2020-07-10', 0);
INSERT INTO `schedule` VALUES (11, 'Tarcísio Gomes de Freitas', NULL, 'Infraestrutura', 'MI', 'https://www.gov.br/infraestrutura/pt-br/acesso-a-informacao/agendas-de-autoridades/ministro-tarcisio-gomes-de-freitas/', NULL, '2019-01-01', 0);
INSERT INTO `schedule` VALUES (12, 'Anderson Torres', 'PSL', 'Justiça e Segurança Pública', 'MJSP', 'https://www.gov.br/mj/pt-br/acesso-a-informacao/agenda-de-autoridades/ministro/agenda-do-ministro/', NULL, '2020-03-30', 0);
INSERT INTO `schedule` VALUES (13, 'Ricardo Salles', NULL, 'Meio Ambiente', 'MMA', 'https://www.gov.br/mma/pt-br/acesso-a-informacao/agenda-de-autoridades-1/agenda-do-ministro-do-meio-ambiente/agenda-do-ministro-do-meio-ambiente-2/', NULL, '2019-01-01', 0);
INSERT INTO `schedule` VALUES (14, 'Bento Albuquerque', NULL, 'Minas e Energia', 'MME', 'https://www.gov.br/mme/pt-br/acesso-a-informacao/agendas-de-autoridades/ministro-bento-albuquerque/', NULL, '2019-01-01', 0);
INSERT INTO `schedule` VALUES (15, 'Damares Alves', NULL, 'Mulher, Família e Direitos Humanos', 'MMFDH', 'https://www.gov.br/mdh/pt-br/acesso-a-informacao/agenda-de-autoridades/agenda-ministra/', NULL, '2019-01-01', 0);
INSERT INTO `schedule` VALUES (16, 'Carlos Alberto Franco França', NULL, 'Relações Exteriores', 'MRE', 'https://www.gov.br/mre/pt-br/agendas/agenda-do-ministro-das-relacoes-exteriores/', NULL, '2021-03-30', 0);
INSERT INTO `schedule` VALUES (17, 'Gilson Machado', NULL, 'Turismo', 'MTur', 'https://www.gov.br/turismo/pt-br/acesso-a-informacao/agenda-de-autoridades/agenda-do-ministro-do-turismo-gilson-machado-neto/', NULL, '2020-12-09', 0);
INSERT INTO `schedule` VALUES (18, 'Wagner Rosário', NULL, 'Controladoria-Geral da União', 'CGU', 'https://www.gov.br', NULL, '2020-05-31', 0);
INSERT INTO `schedule` VALUES (19, 'Flávia Arruda', 'PL', 'Secretaria de Governo', 'SeGov', 'https://www.gov.br/secretariadegoverno/pt-br/acesso-a-informacao/agenda-de-autoridades/copy_of_agendas/ministra/ministra-chefe/', NULL, '2021-03-30', 0);
INSERT INTO `schedule` VALUES (20, 'Onyx Lorenzoni', NULL, 'Secretaria-Geral', 'SGPR', 'https://www.gov.br/secretariageral/pt-br/acesso-a-informacao/agenda-de-autoridades/gabinete-do-ministro/agenda-do-ministro-de-estado-chefe-da-secretaria-geral-da-presidencia-da-republica-onyx-lorenzoni/', NULL, '2021-02-12', 0);
INSERT INTO `schedule` VALUES (21, 'André Mendonça', NULL, 'Advocacia-Geral da União', 'AGU', 'https://www.gov.br/mj/pt-br/acesso-a-informacao/agenda-de-autoridades/ministro/agenda-do-ministro/', NULL, '2020-04-28', 0);
INSERT INTO `schedule` VALUES (22, 'Luiz Eduardo Ramos', NULL, 'Casa Civil', 'CC', 'https://www.gov.br/casacivil/pt-br/acesso-a-informacao/agendas-da-casa-civil/agenda-de-57/', NULL, '2021-03-30', 0);
INSERT INTO `schedule` VALUES (23, 'Augusto Heleno', NULL, 'Gabinete de Segurança Institucional', 'GSI', 'https://www.gov.br/gsi/pt-br/acesso-a-informacao/agendas-de-autoridades/agenda-do-ministro-chefe-do-gabinete-de-seguranca-institucional/', NULL, '2019-01-01', 0);

SET FOREIGN_KEY_CHECKS = 1;

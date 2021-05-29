- [1. Introduction](#1-introduction)
  - [1.1 Description](#11-description)
  - [1.2 Installation](#12-installation)
    - [1.2.1 Pre-requirement](#121-pre-requirement)
    - [1.2.2 Quickstart](#122-quickstart)
    - [1.2.3 Post Installation](#123-post-installation)
  - [1.3. Usage](#13-usage)
- [2. Backgound](#2-backgound)
  - [2.1 Kebutuhan penyederhanaan akses Pengguna ke banyak Aplikasi](#21-kebutuhan-penyederhanaan-akses-pengguna-ke-banyak-aplikasi)
  - [2.1 Role Base Access Control](#21-role-base-access-control)
- [3. Issues](#3-issues)
  - [3.1 list of issues related to required packed](#31-list-of-issues-related-to-required-packed)

# 1. Introduction

## 1.1 Description
## 1.2 Installation
### 1.2.1 Pre-requirement
### 1.2.2 Quickstart
### 1.2.3 Post Installation

## 1.3. Usage

# 2. Backgound
## 2.1 Kebutuhan penyederhanaan akses Pengguna ke banyak Aplikasi
Until 2021 Kemlu stil doesn't have Single SignOn Infrastructure. Some effort have already taken but no result can be seen.

To overcome this problem, i have initiate this project to provide simplified Single SignOn Infrastructur for a limited self-made application by Pustik KP.  
this restriction is made to reduce the complexity of the the project and to keep the changes made to the affected application under control. 
## 2.1 Role Base Access Control
# 3. Issues

## 3.1 list of issues related to required packed

- Uncaught GuzzleHttp\Exception\RequestException: cURL error 60: SSL certificate problem: self signed certificate in certificate chain 

To fix this error, follow the steps below:
1. Open http://curl.haxx.se/ca/cacert.pem
2. Copy the entire page and save it as a “cacert.pem”
3. `mv cacert.cer /usr/local/etc/httpd/ssl` or to other location
4. Open your php.ini file and insert or update the following line.
   ```curl.cainfo = “/usr/local/etc/httpd/ssl/cacert.cer”```
*** Settings ***   
Library          SeleniumLibrary
Test Teardown    Close Browser

*** Variables ***
${BROWSER}           chrome
${HOME_URL}          https://cs0404.cpkkuhost.com/login
${WAIT_TIME}         3s
${WEBDRIVER_PATH}    /Users/ptpspp/Documents/GitHub/git-group-repository-group-4-sec-4/test/chromedriver-mac-arm64/chromedriver

# ฟิลด์สำหรับล็อกอิน
${USER}             admin@gmail.com
${PASSWORD}         12345678
${USER_FIELD}       id=username
${PASSWORD_FIELD}   id=password
${LOGIN_BUTTON}     xpath=//button[@type='submit']

# เมนู 
${DASHBOARD_MENU}   xpath=//a[contains(@href, '/profile')]

# เปลี่ยนภาษา (ตัวเลือกใน dropdown)
${LANG_DROPDOWN_TOGGLE}    xpath=//a[@id="languageDropdown"]
${LANG_TO_THAI}       xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/th')]
${LANG_TO_CHINESE}    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(@href, '/lang/zh')]

# ข้อความที่ต้องตรวจสอบในหน้า "Account"
@{ACCOUNT_SETTINGS_TH}    
...    บัญชี 
...    รหัสผ่าน    
...    การตั้งค่าโปรไฟล์
...    คำนำหน้า
...    ชื่อ
...    นามสกุล
...    อีเมล
...    อัปเดต

@{ACCOUNT_SETTINGS_EN}    
...    Account 
...    Password    
...    Profile Settings
...    Name title
...    First name
...    Last name
...    Email
...    Update

@{ACCOUNT_SETTINGS_ZH}    
...    账户
...    密码
...    个人资料设置
...    前缀
...    名字
...    姓氏
...    名字
...    姓氏

# ข้อความที่ต้องตรวจสอบในหน้า "Password Settings"
@{PASSWORD_SETTINGS_TH}    
...    การตั้งค่ารหัสผ่าน 
...    รหัสผ่านเดิม    
...    รหัสผ่านใหม่
...    ยืนยันรหัสผ่านใหม่

@{PASSWORD_SETTINGS_EN}    
...    Password Settings
...    Old password
...    Confirm new password

@{PASSWORD_SETTINGS_ZH}    
...    密码设置
...    旧密码
...    新密码
...    确认新密码

*** Keywords ***
Open Browser To Home Page
    Open Browser    ${HOME_URL}    ${BROWSER}    executable_path=${WEBDRIVER_PATH}
    Maximize Browser Window

Login As Admin
    Input Text    ${USER_FIELD}    ${USER}
    Input Text    ${PASSWORD_FIELD}    ${PASSWORD}
    Click Button  ${LOGIN_BUTTON}
    Wait Until Element Is Visible  ${DASHBOARD_MENU}  timeout=5s
    Go To    https://cs0404.cpkkuhost.com/profile   # ไปที่หน้าโปรไฟล์โดยตรง
    Log  "Login Successful, navigated to Profile page."

Change Language To Thai
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_THAI}    timeout=10s
    Click Element    ${LANG_TO_THAI}
    Log  "Language changed to Thai successfully."

Change Language To English
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_ENGLISH}    timeout=10s
    Click Element    ${LANG_TO_ENGLISH}
    Log  "Language changed to English successfully."

Change Language To Chinese
    Click Element    ${LANG_DROPDOWN_TOGGLE}
    Sleep    2s
    Wait Until Element Is Enabled    ${LANG_TO_CHINESE}    timeout=10s
    Click Element    ${LANG_TO_CHINESE}
    Log  "Language changed to Chinese successfully."

Verify Account Settings Thai
    Click Element    xpath=//a[@id="account-tab"]
    Wait Until Element Is Visible    xpath=//a[@id="account-tab"]    timeout=5s

    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{ACCOUNT_SETTINGS_TH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Account settings verified successfully in Thai."    INFO
    Log To Console  "✅ Account settings verified successfully in Thai."  # แสดงผลบน Console

Verify Account Settings English
    Click Element    xpath=//a[@id="account-tab"]
    Wait Until Element Is Visible    xpath=//a[@id="account-tab"]    timeout=5s

    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาอังกฤษ
    FOR    ${TEXT}    IN    @{ACCOUNT_SETTINGS_EN}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Account settings verified successfully in English."    INFO
    Log To Console  "✅ Account settings verified successfully in English."  # แสดงผลบน Console

Verify Account Settings Chinese
    Click Element    xpath=//a[@id="account-tab"]
    Wait Until Element Is Visible    xpath=//a[@id="account-tab"]    timeout=5s

    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาจีน
    FOR    ${TEXT}    IN    @{ACCOUNT_SETTINGS_ZH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Account settings verified successfully in Chinese."    INFO
    Log To Console  "✅ Account settings verified successfully in Chinese."  # แสดงผลบน Console

Verify Password Settings Thai
    Click Element    xpath=//a[@id="password-tab"]
    Wait Until Element Is Visible    xpath=//a[@id="password-tab"]    timeout=5s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาไทย
    FOR    ${TEXT}    IN    @{PASSWORD_SETTINGS_TH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Password settings verified successfully in Thai."    INFO
    Log To Console  "✅ Password settings verified successfully in Thai."  # แสดงผลบน Console

Verify Password Settings English
    Click Element    xpath=//a[@id="password-tab"]
    Wait Until Element Is Visible    xpath=//a[@id="password-tab"]    timeout=5s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาอังกฤษ
    FOR    ${TEXT}    IN    @{PASSWORD_SETTINGS_EN}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Password settings verified successfully in English."    INFO
    Log To Console  "✅ Password settings verified successfully in English."  # แสดงผลบน Console

Verify Password Settings Chinese
    Click Element    xpath=//a[@id="password-tab"]
    Wait Until Element Is Visible    xpath=//a[@id="password-tab"]    timeout=5s
    ${PAGE_TEXT}    Get Text    xpath=//body
    # ตรวจสอบข้อความภาษาจีน
    FOR    ${TEXT}    IN    @{PASSWORD_SETTINGS_ZH}
        Should Contain    ${PAGE_TEXT}    ${TEXT}
    END
    Log  "Password settings verified successfully in Chinese."    INFO
    Log To Console  "✅ Password settings verified successfully in Chinese."  # แสดงผลบน Console

*** Test Cases ***
Admin Login And Change Language To Thai
    Open Browser To Home Page
    Login As Admin
    Change Language To Thai
    Verify Account Settings Thai
    Verify Password Settings Thai
    Close Browser

Admin Login And Change Language To English
    Open Browser To Home Page
    Login As Admin
    Verify Account Settings English
    Verify Password Settings English
    Close Browser

Admin Login And Change Language To Chinese
    Open Browser To Home Page
    Login As Admin
    Change Language To Chinese
    Verify Account Settings Chinese
    Verify Password Settings Chinese
    Close Browser

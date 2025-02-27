*** Settings ***
Library          SeleniumLibrary
Test Teardown    Close Browser

*** Variables ***
${BROWSER}         chrome
${LOGIN_URL}       http://cs0404.cpkkuhost.com/login

# Login Page Elements
${LOGIN_PAGE_HEADER}    xpath=//h1[contains(text(), 'ACCOUNT LOGIN') or contains(text(), 'เข้าสู่ระบบบัญชี') or contains(text(), '账户登录')]
${USERNAME_FIELD}       xpath=//input[@name='username']
${PASSWORD_FIELD}       xpath=//input[@name='password']
${LOGIN_BUTTON}         xpath=//button[contains(text(), 'LOG IN') or contains(text(), 'เข้าสู่ระบบ') or contains(text(), '登录')]

# Language Buttons
${LANG_TO_THAI}       xpath=//a[contains(text(), 'ไทย')]
${LANG_TO_ENGLISH}    xpath=//a[contains(text(), 'English')]
${LANG_TO_CHINESE}    xpath=//a[contains(text(), '中文')]

# Dashboard Elements
${DASHBOARD_HEADER}    xpath=//h1[contains(text(), 'Research Information Management System') or contains(text(), 'ระบบจัดการข้อมูลการวิจัย') or contains(text(), '研究信息管理系统')]
${LOGOUT_BUTTON}       xpath=//a[contains(text(), 'Logout') or contains(text(), 'ออกจากระบบ') or contains(text(), '注销')]

# Manage Fund Elements
${MANAGE_FUND_MENU}    xpath=//a[contains(@class,'nav-link') and .//span[contains(@class,'menu-title') and (contains(text(),'Manage Fund') or contains(text(),'จัดการทุนวิจัย') or contains(text(),'基金管理'))]]

# ปุ่ม Add
${ADD_FUND_BUTTON}    xpath=//div[contains(@class,'card-body')]//a[contains(@href, '/funds/create')]

*** Keywords ***
Open Browser To Login Page
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Wait Until Element Is Visible    ${LOGIN_PAGE_HEADER}    timeout=10s

Login As Admin
    [Arguments]    ${username}    ${password}
    Input Text    ${USERNAME_FIELD}    ${username}
    Input Text    ${PASSWORD_FIELD}    ${password}
    Click Element    ${LOGIN_BUTTON}
    Wait Until Element Is Visible    ${DASHBOARD_HEADER}    timeout=10s

Change Language
    [Arguments]    ${language_button}
    Click Element    ${language_button}
    Sleep    3s

Go To Manage Fund
    Wait Until Element Is Visible    ${MANAGE_FUND_MENU}    timeout=10s
    Click Element    ${MANAGE_FUND_MENU}

Go To Add Fund
    Scroll Element Into View    ${ADD_FUND_BUTTON}
    Wait Until Element Is Visible    ${ADD_FUND_BUTTON}    timeout=15s
    Log    ${ADD_FUND_BUTTON}
    Log Source
    Click Element    ${ADD_FUND_BUTTON}
    Sleep    2s

Click Add Fund And Verify
    Sleep    3s
    Page Should Contain Element    ${ADD_FUND_BUTTON}

Logout
    Click Element    ${LOGOUT_BUTTON}
    Wait Until Element Is Visible    ${LOGIN_PAGE_HEADER}    timeout=10s

Verify Page Contains Multiple Texts
    [Arguments]    @{expected_texts}
    ${html_source}=    Get Source
    Log    HTML Source: ${html_source}
    FOR    ${text}    IN    @{expected_texts}
        Should Contain    ${html_source}    ${text}
    END

*** Test Cases ***
Test Admin Manage Fund In English
    Open Browser To Login Page
    Login As Admin    admin@gmail.com    12345678
    Go To Manage Fund
    Change Language    ${LANG_TO_ENGLISH}
    Go To Add Fund
    Logout

Test Admin Manage Fund In Thai
    Open Browser To Login Page
    Login As Admin    admin@gmail.com    12345678
    Go To Manage Fund
    Go To Add Fund
    Logout

Test Admin Manage Fund In Chinese
    Open Browser To Login Page
    Login As Admin    admin@gmail.com    12345678
    Go To Manage Fund
    Change Language    ${LANG_TO_CHINESE}
    Go To Add Fund
    Logout
